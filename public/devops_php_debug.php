<?php

declare(strict_types=1);

try {
    $environment_name = $_SERVER['ENVIRONMENT_NAME'] ?? 'development';

    $debug_mode = preg_match($pattern = '/(development?|staging)/im', $subject = $environment_name);

    if ($debug_mode) {
        ini_set('ignore_repeated_errors', 'On');
        ini_set('html_errors', 'On');
        ini_set('display_errors', 'On');
        error_reporting(E_ALL);
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'ptb', 'portuguese-brazil', 'pt-br', 'bra', 'brazil');
    }

    $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    if ($uri === '/debug' && $debug_mode) {
        http_response_code(200);
        exit(check_services_statuses());
    }
} catch (Throwable $e) {
    if ($debug_mode) {
        echo $e->getMessage();
        echo $e->getCode();
        exit(1);
    }
    http_response_code($e->getCode());
    exit('Um erro inesperado ocorreu! Lamentamos pelo inconveniente!');
}

function alive_template(stdClass $params): string
{
    return <<<EOL
    <meta http-equiv="refresh" content="60">
    <style>
        .container-fluid {
            width: 1100px;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .green-text {
            color: #28a745 !important;
        }

        .red-text {
            color: #dc3545 !important;
        }

        .td-size-min {
            width: 30%;
        }

        .td-size-max {
            width: 70%;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }

        .table .table {
            background-color: #fff;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-borderless th,
        .table-borderless td,
        .table-borderless thead th,
        .table-borderless tbody + tbody {
              border: 0;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-primary,
        .table-primary > th,
        .table-primary > td {
            background-color: #b8daff;
        }

        .table-hover .table-primary:hover {
            background-color: #9fcdff;
        }

        .table-hover .table-primary:hover > td,
        .table-hover .table-primary:hover > th {
            background-color: #9fcdff;
        }

        .table-secondary,
        .table-secondary > th,
        .table-secondary > td {
            background-color: #d6d8db;
        }

        .table-hover .table-secondary:hover {
            background-color: #c8cbcf;
        }

        .table-hover .table-secondary:hover > td,
        .table-hover .table-secondary:hover > th {
            background-color: #c8cbcf;
        }

        .table-success,
        .table-success > th,
        .table-success > td {
            background-color: #c3e6cb;
        }

        .table-hover .table-success:hover {
            background-color: #b1dfbb;
        }

        .table-hover .table-success:hover > td,
        .table-hover .table-success:hover > th {
            background-color: #b1dfbb;
        }

        .table-info,
        .table-info > th,
        .table-info > td {
            background-color: #bee5eb;
        }

        .table-hover .table-info:hover {
            background-color: #abdde5;
        }

        .table-hover .table-info:hover > td,
        .table-hover .table-info:hover > th {
            background-color: #abdde5;
        }

        .table-warning,
        .table-warning > th,
        .table-warning > td {
            background-color: #ffeeba;
        }

        .table-hover .table-warning:hover {
            background-color: #ffe8a1;
        }

        .table-hover .table-warning:hover > td,
        .table-hover .table-warning:hover > th {
            background-color: #ffe8a1;
        }

        .table-danger,
        .table-danger > th,
        .table-danger > td {
            background-color: #f5c6cb;
        }

        .table-hover .table-danger:hover {
            background-color: #f1b0b7;
        }

        .table-hover .table-danger:hover > td,
        .table-hover .table-danger:hover > th {
            background-color: #f1b0b7;
        }

        .table-light,
        .table-light > th,
        .table-light > td {
            background-color: #fdfdfe;
        }

        .table-hover .table-light:hover {
            background-color: #ececf6;
        }

        .table-hover .table-light:hover > td,
        .table-hover .table-light:hover > th {
            background-color: #ececf6;
        }

        .table-dark,
        .table-dark > th,
        .table-dark > td {
            background-color: #c6c8ca;
        }

        .table-hover .table-dark:hover {
            background-color: #b9bbbe;
        }

        .table-hover .table-dark:hover > td,
        .table-hover .table-dark:hover > th {
            background-color: #b9bbbe;
        }

        .table-active,
        .table-active > th,
        .table-active > td {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover > td,
        .table-hover .table-active:hover > th {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table .thead-dark th {
            color: #fff;
            background-color: #212529;
            border-color: #32383e;
        }

        .table .thead-light th {
            color: #495057;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .table-dark {
            color: #fff;
            background-color: #212529;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th {
            border-color: #32383e;
        }

        .table-dark.table-bordered {
            border: 0;
        }

        .table-dark.table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .table-dark.table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.075);
        }
            </style>
    <div class="container-fluid">
        <table class="table table-borderless table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th colspan="2"><h3 class="green-text" >Madeira<strong>Madeira</strong></h3></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="td-size-min">Application:</td>
                    <td class="td-size-max"<td><span class="green-text">$params->appname</span></td>
                </tr>
                <tr>
                    <td class="td-size-min">Container:</td>
                    <td class="td-size-max"<td><span class="green-text">up and running!</span></td>
                </tr>
                <tr>
                    <td class="td-size-min">Ulimit - Hard Limit:</td>
                    <td class="td-size-max"<td><span class="green-text">$params->hl</span></td>
                </tr>
                <tr>
                    <td class="td-size-min">Ulimit - Soft Limit:</td>
                    <td class="td-size-max"<td><span class="green-text">$params->sl</span></td>
                </tr>
                <tr>
                    <td class="td-size-min">CPU Usage:</td>
                    <td class="td-size-max"<td><span class="green-text">$params->cpu_usage</span></td>
                </tr>
                <tr>
                    <td class="td-size-min">Memory Usage:</td>
                    <td class="td-size-max"<td><span class="green-text">$params->memory_usage</span></td>
                </tr>
                <tr>
                    <td class="td-size-min">PHP version:</td>
                    <td class="td-size-max"><span class="green-text">$params->php_version</span></td>
                </tr>
                <tr>
                    <td class="td-size-min">DotEnv (.env) Acessibility</td>
                    <td class="td-size-max">$params->dotenv_accessibility</td>
                </tr>
                <tr>
                    <td class="td-size-min">DotEnv (.env) Data</td>
                    <td class="td-size-max">$params->dotenv_file_data</td>
                </tr>
                <tr>
                    <td class="td-size-min">Vendor (autoload.php) Acessibility</td>
                    <td class="td-size-max">$params->autoload_accessibility</td>
                </tr>
                <tr>
                    <td class="td-size-min">Redis Connection</td>
                    <td class="td-size-max">$params->redis_status</td>
                </tr>
                <tr>
                    <td class="td-size-min">Database( RDS ) Connection</td>
                    <td class="td-size-max">$params->rds_status</td>
                </tr>
                <tr>
                    <td class="td-size-min">AWS S3 Acessibility</td>
                    <td class="td-size-max">$params->s3_status</td>
                </tr>
                <tr>
                    <td class="td-size-min">AWS SQS Acessibility</td>
                    <td class="td-size-max">$params->sqs_status</td>
                </tr>
                <tr>
                    <td class="td-size-min">AWS SNS Acessibility</td>
                    <td class="td-size-max">$params->sns_status</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <small></small>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    EOL;
}

function check_services_statuses(): string
{
    $params                         = new stdClass();
    $params->appname                = $_SERVER['APPNAME'] ?? $_ENV['APPLICATION_NAME'] ?? '';
    $params->sl                     = (get_open_files_limit())->sl ?? '';
    $params->hl                     = (get_open_files_limit())->hl ?? '';
    $params->cpu_usage              = get_server_cpu_usage();
    $params->memory_usage           = get_server_memory_usage();
    $params->php_version            = PHP_VERSION;
    $params->dotenv_accessibility   = test_dotenv_accessibility();
    $params->dotenv_file_data       = get_dotenv_file_data();
    $params->autoload_accessibility = test_vendor_accessibility();
    $params->redis_status           = test_redis_connect();
    $params->rds_status             = test_rds_connect();
    $params->s3_status              = test_s3_accessibility();
    $params->sqs_status             = test_sqs_accessibility();
    $params->sns_status             = test_sns_accessibility();

    return alive_template($params);
}

function get_open_files_limit(): stdClass
{
    $output = new stdClass();

    try {
        $output->sl = (int)(shell_exec('ulimit -Sn') ?? 0);
        $output->hl = (int)(shell_exec('ulimit -Hn') ?? 0);
    } catch (Throwable) {
        $output->sl = '<span class="red-text">Unavailable</span>';
        $output->hl = '<span class="red-text">Unavailable</span>';
    }

    return $output;
}

function get_server_cpu_usage(): string
{
    try {
        $cpu_count = 1;
        if (is_file('/proc/cpuinfo')) {
            $cpu_info = file_get_contents('/proc/cpuinfo');
            preg_match_all('/^processor/m', $cpu_info, $matches);
            $cpu_count = count($matches[0]);
        }

        @$loads = sys_getloadavg();

        if (empty($loads) || !is_array($loads) || empty($loads[0])) {
            throw new DomainException();
        }

        $load   = round($loads[0] / $cpu_count * 100, 2);
        $output = $load > 80
            ? "<span class=\"red-text\">Too busy: $load%</span>"
            : "<span class=\"green-text\">$load%</span>";
    } catch (Throwable) {
        $output = '<span class="red-text">Unavailable</span>';
    }

    return $output;
}

function get_server_memory_usage(): string
{
    try {
        $free       = shell_exec('free -m');
        $free       = trim($free);
        $free_array = explode("\n", $free);
        $memory     = explode(' ', @$free_array[1]);
        $memory     = array_filter($memory);
        $memory     = array_merge($memory);

        if (empty($memory) || empty($memory[1]) || empty($memory[6])) {
            throw new DomainException();
        }

        $memory_usage = round($memory[6] / $memory[1] * 100, 2);

        $output = $memory_usage > 80
            ? "<span class=\"red-text\">Too busy: $memory_usage%</span>"
            : "<span class=\"green-text\">$memory_usage%</span>";
    } catch (Throwable) {
        $output = '<span class="red-text">Unavailable</span>';
    }

    return $output;
}

function test_dotenv_accessibility(): string
{
    try {
        $dot_env_file = '/var/www/.env';
        $command      = "[ -r $dot_env_file ] && cat $dot_env_file | grep APPLICATION_ENV=";
        $reachable    = (@shell_exec($command)) ?? false;

        if (!$reachable) {
            throw new DomainException();
        }
    } catch (Throwable) {
        return '<span class="red-text">Unreachable</span>';
    }

    return '<span class="green-text">Reachable</span>';
}

function get_dotenv_file_data(): string
{
    try {
        $dot_env_file = '/var/www/.env';
        $command      = "[ -r $dot_env_file ] && cat $dot_env_file | grep APPLICATION_ENV=";
        $reachable    = (@shell_exec($command)) ?? false;

        if (!$reachable) {
            throw new DomainException();
        }
        $dot_env = @shell_exec("cat $dot_env_file");
    } catch (Throwable) {
        return '<span class="red-text">Unreachable</span>';
    }

    return $dot_env;
}

function test_vendor_accessibility(): string
{
    try {
        $autoloadFile = '/var/www/vendor/autoload.php';
        $command      = "[ -r $autoloadFile ] && cat $autoloadFile ";
        $reachable    = (@shell_exec($command)) ?? false;

        if (!$reachable) {
            throw new DomainException();
        }
    } catch (Throwable) {
        return '<span class="red-text">Unreachable</span>';
    }

    return '<span class="green-text">Reachable</span>';
}

function test_redis_connect(): string
{
    try {
        $app_name         = $_SERVER['APPNAME'] ?? $_ENV['APPLICATION_NAME'] ?? '';
        $environment_name = $_SERVER['ENVIRONMENT_NAME'] ?? 'development';

        if ($environment_name === 'development') {
            return '<span class="green-text">N/A</span>';
        }

        $redis_uri = $environment_name === 'staging'
            ? "$app_name-redis-staging.redekasa.com"
            : "$app_name-redis-production-madeiramadeira.com.br";

        $response = (shell_exec('exec 3<>/dev/tcp/' . $redis_uri . '/6379 && echo -e "PING\r\n" >&3 && head -c 7 <&3'));

        if (!empty($response)) {
            $output = '<span class="green-text">Reachable</span>';
        }
    } catch (Throwable $e) {
        echo $e->getMessage();
        $output = '<span class="red-text">Unreachable</span>';
    }

    return $output;
}

function test_rds_connect(): string
{
    try {
        $config1           = [
            'driver'   => 'mysql',
            'host'     => getenv('DB_FIRSTCLASS_RO_HOST'),
            'user'     => getenv('DB_FIRSTCLASS_RO_USER'),
            'password' => getenv('DB_FIRSTCLASS_RO_PASS'),
            'db_name'  => getenv('DB_FIRSTCLASS_RO_BASE'),
        ];
        $connectionString1 = $config1['driver'] . ':host=' . $config1['host'] . ';dbname=' . $config1['db_name'];
        $connection1       = new PDO($connectionString1, $config1['user'], $config1['password']);
        $connection1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection1->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");

        $config2           = [
            'driver'   => 'mysql',
            'host'     => getenv('DB_WARLOCK_RO_HOST'),
            'user'     => getenv('DB_WARLOCK_RO_USER'),
            'password' => getenv('DB_WARLOCK_RO_PASS'),
            'db_name'  => getenv('DB_WARLOCK_RO_BASE'),
        ];
        $connectionString2 = $config2['driver'] . ':host=' . $config2['host'] . ';dbname=' . $config2['db_name'];
        $connection2       = new PDO($connectionString2, $config2['user'], $config2['password']);
        $connection2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection2->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");

        $output = '<span class="green-text">Reachable</span>';
    } catch (Throwable) {
        $output = '<span class="red-text">Unreachable</span>';
    }

    return $output;
}

function test_s3_accessibility(): string
{
    return '<span class="green-text">N/A</span>';

    $aws_region = 'us-east-2';

    try {
        $s3Client = new Aws\S3\S3Client([
            'region'  => $aws_region,
            'version' => '2006-03-01',
        ]);

        $s3Client->getBucketAcl([
            'Bucket' => 'mm-devops-bucket-tester',
        ]);

        $output = '<span class="green-text">Reachable</span>';
    } catch (Throwable) {
        $output = '<span class="red-text">Unreachable</span>';
    }

    return $output;
}

function test_sqs_accessibility(): string
{
    return '<span class="green-text">N/A</span>';

    $environment_name = $_SERVER['ENVIRONMENT_NAME'] ?? 'development';
    $aws_region       = 'us-east-2';
    $aws_queue_name   = 'mm-devops-sqs-tester';
    $aws_acc          = (preg_match('/(development?|staging)/im', $environment_name))
        ? '683720833731'
        : '872673025589';

    try {
        $client = new Aws\Sqs\SqsClient([
            'region'  => $aws_region,
            'version' => '2012-11-05',
        ]);

        $client->getQueueUrl([
            'QueueName' => $aws_queue_name,
        ]);

        $output = '<span class="green-text">Reachable</span>';
    } catch (Throwable) {
        $output = '<span class="red-text">Unreachable</span>';
    }

    return $output;
}

function test_sns_accessibility(): string
{
    return '<span class="green-text">N/A</span>';

    $environment_name = $_SERVER['ENVIRONMENT_NAME'] ?? 'development';
    $aws_region       = 'us-east-2';
    $aws_acc          = (preg_match('/(development?|staging)/im', $environment_name))
        ? '683720833731'
        : '872673025589';

    $TopicArn = "arn:aws:sns:$aws_region:$aws_acc:mm-devops-sns-tester";

    try {
        $client = new Aws\Sns\SnsClient([
            'region'  => $aws_region,
            'version' => '2012-11-05',
        ]);

        $client->getTopicAttributes([
            'TopicArn' => $TopicArn,
        ]);

        $output = '<span class="green-text">Reachable</span>';
    } catch (Throwable) {
        $output = '<span class="red-text">Unreachable</span>';
    }

    return $output;
}
