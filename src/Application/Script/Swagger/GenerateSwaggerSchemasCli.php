<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Script\Swagger;

use Nuvemshop\ApiTemplate\Infrastructure\Exception\DomainException;
use Nuvemshop\ApiTemplate\Infrastructure\Swagger\SwaggerMapper;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class GenerateSwaggerSchemasCli extends Command
{
    public const NAME = 'swagger:generate-schemas';

    private SwaggerMapper $mapper;

    public function __construct(private readonly ContainerInterface $container)
    {
        try {
            $mappingPaths = $this->container->get('config')['swagger']['mappingPaths'];
            $this->mapper = new SwaggerMapper($mappingPaths);
        } catch (Throwable $exception) {
            throw new DomainException($exception->getMessage(), (int)$exception->getCode(), $exception->getPrevious());
        }

        parent::__construct(self::NAME);
    }

    protected function configure(): void
    {
        $this
            ->setName(self::NAME)
            ->setDefinition(new InputDefinition([]))
            ->setDescription('Generate Swagger Schemas')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->mapper->mapper() || !$this->mapper->toYaml()) {
            print $this->mapper->exception;
            return self::FAILURE;
        }

        print sprintf("Generated file in: %s \n", $this->mapper::OUTPUT_PATH);
        return self::SUCCESS;
    }
}
