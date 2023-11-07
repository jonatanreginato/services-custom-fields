# <img src="public/assets/images/reino-unido.png" alt="UK flag" style="height: 36px; width:36px; margin-bottom: -7px;"/> Commit pattern

A guide to understanding the importance of commit messages and how to write them well.

It can help you learn what a commit is, understand why it's important to write good messages using best practices and
learn tips for planning and (re)writing your commit history.

## What is a commit?

In simple terms, commit is a kind of snapshot of your local files, saved locally in your repository. Contrary to popular
belief, git doesn't just store the differences, but the complete copy of the files. In the case of files that have not
changed from one commit to the next, a reference to the file generated in the last snapshot is recorded.

The image below shows how git stores data over time with a version for each commit:

<div align="center">
    <br>
    <img src="https://i.imgur.com/yQRxNQE.png"  alt="snapshot"/>
    <br>
    <br>
    <p>Figura 1 - Data flow over time.</p>
    <br>
</div>

## Why are messages important?

* Facilitates and speeds up code review
* Helps in understanding what is going on
* Explains hidden whys that can't be explained in code alone
* Facilitates troubleshooting and debugging by ensuring future developers understand why and how changes were made

We care a lot about making our git history clean, easy to maintain, and easy to access for all of our contributors.
Therefore, commit messages are very important to us, which is why we have a strict commit message policy.

Our commit pattern shown below was based on the well-known pattern used
by [Angular](https://github.com/angular/angular/blob/master/CONTRIBUTING.md#commit),
[Karma](http://karma-runner.github.io/1.0/dev/git-commit-msg.html) and others. A commit message consists of a header, a
body and a footer, separated by a blank line.

Structure:

```
<type>(<optional scope>): <subject>
BLANK LINE
<body>
BLANK LINE
<footer>
```

Example:

```
fix(order/update): adjust the changeStatus function argument

The changeStatus method was receiving XPTO argument.
Now receives the correct argument: FOO.

CRBU-1984 #time 5m
```

The idea of using this pattern is to granularly define what each commit did and what. Furthermore, it makes it easier to
extract any changelog from the application and also improves the visualization of the log without vague commits.

Below is a summary of all the rules we have adopted:

* Commits must be [atômicos](https://en.wikipedia.org/wiki/Atomic_commit#Atomic_commit_convention); if two different
  implementations/fixes are made, they must be implemented in two different commits;
* The header is mandatory;
    * The header type is mandatory;
    * The header scope is optional;
    * The header subject is mandatory;
* The body is optional;
* The footer is optional;
* Don't capitalize the header subject first letter;
* Do not end the header subject line with a period;
* Use the imperative mood in the header subject line;
* Each line of the commit will have a maximum of 72 characters (we recommend 50 characters or less for the message
  header);
* Understanding the commit content should be almost automatic for any contributor and easy for new contributors to
  understand;
* Use the body to explain what and why vs. how,
* Footer messages, when present, should reference the Jira issue number associated with the commit.

For example:

```
type: summarize changes in around 50 characters
 
More detailed explanatory text, if necessary. Wrap it to about 72
characters or so. In some contexts, the first line is treated as the
subject of the commit and the rest of the text as the body. The
blank line separating the summary from the body is critical (unless
you omit the body entirely); various tools like `log`, `shortlog`
and `rebase` can get confused if you run the two together.
 
Explain the problem that this commit is solving. Focus on why you
are making this change as opposed to how (the code explains that).
Are there side effects or other unintuitive consequences of this
change? Here's the place to explain them.
 
Further paragraphs come after blank lines.
 
- Bullet points are okay, too
- Typically a hyphen or asterisk is used for the bullet, preceded
  by a single space, with blank lines in between, but conventions
  vary here
 
If you use an issue tracker, put references to them at the bottom,
like this:
 
Resolves: CRBU-1984 #time 5m
See also: CRBU-2023, CRBU-2024
```

For a better understanding of the importance of a descriptive commit and some examples, read:

* [chris beams](https://chris.beams.io/posts/git-commit/) and
* [tbaggery](http://tbaggery.com/2008/04/19/a-note-about-git-commit-messages.html).

## Message header

The message header is a single line that contains succinct description of the change containing a **type**, an optional
**scope** and a **subject**.

### Type

The types are summarized in **“feat”**, **“fix”**, **“refactor”**, **“style”**, **“docs”**, **“test”**, **“perf”**,
**“build”**, **“ci”** and **“revert”**

#### feat

`feat` are any additions to the code.

While they can change part of the existing code, their focus is on implementing new features to the ecosystem or
improvements to existing features. A new feature for docs, tests, build or ci scripts should not be considered a feat
type.

Examples:

Addition of a service, functionality, endpoint, etc.

`feat: allow provided config object to extend other configs`

`feat(lang): add polish language`

`feat(login): insert domain validation on the login screen`

`feat(routes): add click functions on map markers`

#### fix

`fix` refers to bug fixes. A fix for docs, tests, build or ci scripts should not be considered a fix type.

Examples:

Apply treatment to a function that is not having the expected behavior and returning an error.

`fix(login): fix description property of the email field`

`fix(dashboard): fix decimal point error`

`fix(router): make router provides work with cli and offline compilation`

`fix: resolve shorthand property declarations`

#### refactor

`refactor` refers to any changes that affect the code, but do not alter its functionality.

Did you change the processing format on a certain part of your screen, but maintain the same functionality? Declare as
refactor.

Examples:

Removing redundant code, simplifying the code, renaming variables, code changes after a code review, etc.

`refactor: remove redundat styles`

`refactor: remove deprecated bootstrap`

`refactor(core): simplify and cleanup reflection`

`refactor: change from anonymous functions to arrow function on container config`

#### style

Changes regarding code formatting, semicolons, trailing spaces and lint in general are in style.

Examples:

Indents, remove whitespace, remove comments, etc.

`style(login): insert blank line at the end of login.php file`

`style(core): fix max line length to pass linting`

`style: add space between .home and hamburger`

`style: use single quotes consistently`

#### docs

With `docs`, we have content related to documentation. It will be used when adding comments to the code, phpdoc, jsdoc,
storyboard and everything that does not interfere with the code, but indicates its operation.

Examples:

Add information to the API documentation, change the README, etc.

`docs(login): adiciona jsdoc às funções`

`docs(readme): insere subseção código de conduta ao README`

#### test

`test` will be used when making commits related to modifications and additions to unit and/or end-to-end tests.

Examples:

Creation or modification of unit tests.

`test(login): fix unit tests on the validator class`

`test(dashboard): add e2e test`

`test: add test for missingTranslation parameter`

`test: add attribute interpolation test`

#### perf

`perf` will be used to indicate a change that improved system performance.

Examples:

Remove slow code, improve the graphQL query, etc.

`perf: change ForEach to while in the item filter`

`perf(dashboard): improve graphQL query`

`perf: avoid unnecessary I/O operation in ng-packages-installer`

`perf: remove check for function type in renderStringify`

#### build

`build` will be used to indicate changes that affect the project's build process (involving scripts, configurations or
tools) and package dependencies.

Examples:

Add/remove npm dependencies, edit package.json scripts, etc.

`build: adiciona dependência mm-cz-conventional-changelog`

`build: change license type in package.json`

`build(npm): update fsevents to 1.0.14`

`build(docs-infra): enable ServiceWorker in cli config`

#### ci

`ci` will be used to report changes related to the continuous integration and deployment system - involving scripts,
configurations or tools.

Examples:

Github Actions, Git hooks, CircleCI, Travis, Jenkins etc.

`ci: add payload size limit file`

`ci: re-use setup CircleCI job in aio_monitoring`

`ci: implement unit test triggering in github actions`

`ci: add pre-push git hook`

#### revert

If the commit reverts a previous commit, it must begin with `revert`, followed by the header of the reverted commit.

In the body, it should say `this reverts commit <hash>`, where the “hash” is the **SHA** of the commit being reverted.

Example:

`revert: reverte commit 74a9ef`

### Scope

Scope can be anything specifying place of the commit change; It is important that they are understood in an almost
automatic way for someone who is not familiar with the project. In general, the use of scope is very generic, specifying
only the first context (login, middleware, profile). However, prefer to be more specific and define a second scope (
containers/login, for example).

Assuming that you have refactored the routes related to the project settings, a possible commit would be:

`feat(routes/settings): adjust settings to be called in any screen`

### Subject

Subject must be sufficiently clear, using their space up to the maximum allowed on the line. If you see that the
explanation was not enough, feel free to add content to the body.

**1. It must contain a brief description of the change.**

Try to communicate what the commit does without having to look at the content of the commit.

**2. Use the imperative.**

Use the imperative, present tense: “change” not “changed” nor “changes”.

Why!?

The commit message tells you what it **does**, not what was done.

Golden rule for messages:

**A properly formed Git commit subject line should always be able to complete the following sentence:**

- If applied, this commit will < your subject line here >

Por exemplo:

- If applied, this commit will _refactor subsystem X for readability_
- If applied, this commit will _update getting started documentation_
- If applied, this commit will _remove deprecated methods_
- If applied, this commit will _release version 1.0.0_
- If applied, this commit will _merge pull request #123 from user/branch_

Notice how this doesn’t work for the other non-imperative forms:

- If applied, this commit will _fixed bug with Y_
- If applied, this commit will _changing behavior of X_
- If applied, this commit will _more fixes for broken stuff_
- If applied, this commit will _sweet new API methods_

_Remember: Use of the imperative is important only in the subject line. You can relax this restriction when you’re
writing the body._

**3. Limit the subject line to 50 characters.**

Keeping subject lines at this length ensures that they are readable, and forces the author to think for a moment about
the most concise way to explain what’s going on.

_Tip: If you’re having a hard time summarizing, you might be committing too many changes at once. Strive
for [commits atômicos](https://www.freshconsulting.com/atomic-commits/)._

GitHub’s UI is fully aware of these conventions. It will warn you if you go past the 50 character limit and will
truncate any subject line longer than 72 characters with an ellipsis. So shoot for 50 characters, but consider 72 the
hard limit.

**3. Start the sentence with a lowercase letter.**

This is as simple as it sounds. The reason for choosing to start with a lowercase letter is simply to adhere to the
[@commitlint/config-conventional](https://github.com/conventional-changelog/commitlint/tree/master/%40commitlint/config-conventional).

**4. No dot (.) at the end.**

Trailing punctuation is unnecessary in subject lines. Besides, space is precious when you’re trying to keep them to 50
chars or less.

## Message body

The body, in contrasts with message header subject, must contain more precise descriptions of what is contained in that
commit, showing the reasons or consequences generated by that code, as well as future instructions.

**Use the body to explain what and why vs. how.**

```
# Good
fix: fix name method of InventoryBackend child classes

Classes derived from Inventory Backend were not respecting the base
class interface.

Previously worked because cart was calling the implementation
incorrectly.
```

```
# Good
refactor: add `use` method in Credit class

Changed from namedtuple to class because we need to set a new attribute
(in_use_amount) with a new value.
```

The message title and body are separated by a blank line. Additional blank lines are considered part of the body.

Characters like `-`, `*` and `'` are common elements to improve readability.

In most cases, you can leave out details about how a change has been made. Code is generally self-explanatory in this
regard (and if the code is so complex that it needs to be explained in prose, that’s what source comments are for). Just
focus on making clear the reasons why you made the change in the first place — the way things worked before the change (
and what was wrong with that), the way they work now, and why you decided to solve it the way you did.

The future maintainer that thanks you may be yourself!

## Message footer

The footer is restricted to status changes via **smart commit**, such as issues status resolutions. The idea is that in
the
future it will be possible with **smart commits** to associate the commit with a issue of Jira and change its status
automatically with keywords like `comment`, `close`, `time`.

Example: CRBU-1984 #time 1h #close #comment Bug fixed.

## Recommendations

**Avoid commits with generic messages or without any context**

```
# Ruim
fix this

fix stuff

now it will work

change stuff
adjust css
```

**Try limiting the number of message columns**

[It is recommended](https://git-scm.com/book/en/v2/Distributed-Git-Contributing-to-a-Project#_commit_guidelines) 50
characters for the title and around 72 for the body.

**Tip**: Configure your editor([nano¹](http://stackoverflow.com/a/31844714),
[Vim²](https://robots.thoughtbot.com/5-useful-tips-for-a-better-commit-message)) to break the line at 72 characters.

### Maintain language consistency

```
# Bom
ababab refactor: add `use` method to Credit model
efefef refactor: use InventoryBackendPool to retrieve inventory backend
bebebe fix: fix method name of InventoryBackend child classes
```

```
# Bom
ababab refactor: adiciona o método `use` ao model Credit
efefef refactor: usa o InventoryBackendPool para recuperar o backend de estoque
bebebe fix: corrige nome de método na classe InventoryBackend
```

```
# Ruim
ababab refactor: agregue el método "use" al modelo de crédito
efefef refactor: usa o InventoryBackendPool para recuperar o backend de estoque
bebebe fix: fix method name of InventoryBackend child classes
```

### Breaking Change

If there is a drastic change that will break functionality, you **MUST** indicate it in the body with **'BREAKING
CHANGE'** (yes, in capital letters) and explain the reasons that led to this marking.

## Notes

1. [nano](https://www.nano-editor.org/)
2. [vim](https://www.vim.org/)

## References

1. [Contributing to Angular](https://github.com/angular/angular/blob/main/CONTRIBUTING.md#commit)
2. [Karma - Git Commit Msg](http://karma-runner.github.io/1.0/dev/git-commit-msg.html)
3. [Chris Beams - How to Write a Git Commit Message](https://cbea.ms/git-commit/)
4. [tbaggery - A Note About Git Commit Messages](https://tbaggery.com/2008/04/19/a-note-about-git-commit-messages.html)
5. [conventional-changelog/commitlint](https://github.com/conventional-changelog/commitlint/tree/master/%40commitlint/config-conventional)
6. [Git - Commit Guidelines](https://git-scm.com/book/en/v2/Distributed-Git-Contributing-to-a-Project#_commit_guidelines)
7. [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/)
8. [Spring framework - Format commit messages](https://github.com/spring-projects/spring-framework/blob/30bce7/CONTRIBUTING.md#format-commit-messages)

# <img src="public/assets/images/brasil.png" alt="Brazil flag" style="height: 36px; width:36px; margin-bottom: -7px;"/> Padrão de Commit

Um guia para entender a importância das mensagens de commit e como escrevê-las bem.

Pode te ajudar a aprender o que é um commit, entender porque é importante escrever boas mensagens usando boas práticas
e conhecer dicas para planejar e (re)escrever o seu histórico de commits.

## O que é um commit?

Em termos simples, o commit é uma espécie de “snapshot” dos seus arquivos locais, gravado localmente no seu repositório.
Ao contrário do que se pensa, o git não armazena apenas as diferenças e sim a cópia completa dos arquivos.
No caso de arquivos que não mudaram de um commit para o outro, é gravada uma referência ao arquivo gerado no último
“snapshot”.

A imagem abaixo mostra como o git armazena dados ao longo do tempo com uma versão para cada commit:

<div align="center">
    <br>
    <img src="https://i.imgur.com/yQRxNQE.png"  alt="snapshot"/>
    <br>
    <br>
    <p>Figura 1 - Fluxo de dados ao longo do tempo.</p>
    <br>
</div>

## Por que as mensagens são importantes?

* Facilita e agiliza o “code review”
* Ajuda no entendimento do que está acontecendo
* Explica os porquês ocultos que não podem ser explicados somente em código
* Facilita a solução de problemas e a depuração garantindo que futuros desenvolvedores entendam por que e como as
  mudanças foram feitas

Nós nos preocupamos muito em tornar nosso histórico do git limpo, fácil de manter e de fácil acesso para todos os nossos
contribuidores. Portanto, as mensagens de “commit” são muito importantes para nós, e é por isso que temos uma política
rígida de mensagens de commit.

Nosso padrão de commit apresentado a seguir foi baseado no padrão bastante conhecido e usado pelo
[Angular](https://github.com/angular/angular/blob/master/CONTRIBUTING.md#commit),
[Karma](http://karma-runner.github.io/1.0/dev/git-commit-msg.html) e outros:

Estrutura:

```
<tipo>(<escopo>): <descrição>
<LINHA EM BRANCO>
<corpo>
<LINHA EM BRANCO>
<rodapé>
```

Exemplo:

```
fix(order/update): ajusta o argumento da função changeStatus

O método changeStatus estava recebendo argumento XPTO.
Agora recebe o argumento correto: FOO.

CRBU-1984 #time 5m
```

A ideia de usar esse padrão, é termos de forma granulada o que cada commit fez e onde. Além disso, facilita na hora de
extrair algum changelog da aplicação e além de melhorar a visualização do log sem commits vagos.

Abaixo está um resumo de todas as regras que adotamos:

* Os commits devem ser [atômicos](https://en.wikipedia.org/wiki/Atomic_commit#Atomic_commit_convention); se duas
  implementações/correções distintas são realizadas, elas devem ser implementadas em dois commits diferentes;
* O cabeçalho é obrigatório;
    * O tipo do cabeçalho é obrigatório;
    * O escopo do cabeçalho é opcional;
    * A descrição do cabeçalho é obrigatório;
* O corpo é opcional;
* O rodapé é opcional;
* Não coloque a primeira letra do assunto do cabeçalho em maiúscula;
* Não termine a linha de assunto do cabeçalho com um ponto final;
* Use o modo imperativo na descrição do cabeçalho;
* Cada linha do commit terá no máximo 72 caracteres;
* A compreensão do conteúdo do commit deve ser quase que automática para qualquer contribuidor e de fácil compreensão
  para novos contribuidores;
* Use o corpo para explicar o que e por que, não como;
* A mensagem de rodapé, quando presente, deve fazer referência ao número da tarefa no **Jira** associada ao commit;

Por exemplo:

```
tipo: resuma as mudanças em cerca de 50 caracteres

Texto explicativo mais detalhado, se necessário. Envolva-o em cerca de
72 caracteres ou mais. Em alguns contextos, a primeira linha é tratada
como assunto do commit e o restante do texto como corpo. A linha em
branco que separa o resumo do corpo é crítica (a menos que você omita
totalmente o corpo); várias ferramentas como `log`, `shortlog` e
`rebase` podem ficar confusas se você executar os dois juntos.

Explique o problema que este commit está resolvendo. Concentre-se no
motivo pelo qual você está fazendo essa alteração e não em como (o
código explica isso). Existem efeitos colaterais ou outras consequências
não intuitivas dessa mudança? Aqui é o lugar para explicá-los.

Os parágrafos seguintes vêm após as linhas em branco.

- Marcadores também são possíveis
- Normalmente, um hífen ou asterisco é usado para o marcador, precedido
  por um único espaço, com linhas em branco entre eles, mas as convenções
  variam aqui

Se você usa um rastreador de problemas, coloque referências a eles na parte
inferior, assim:
 
Corrige: CRBU-1984 #time 5m
Veja também: CRBU-2023, CRBU-2024
```

Para uma melhor compreensão da importância de um commit descritivo e alguns exemplos, leia:

* [chris beams](https://chris.beams.io/posts/git-commit/) e
* [tbaggery](http://tbaggery.com/2008/04/19/a-note-about-git-commit-messages.html).

## Cabeçalho

O cabeçalho da mensagem é uma única linha que contém uma descrição sucinta da mudança contendo um tipo, um escopo
opcional e uma descrição.

### Tipo

Os tipos se resumem em **“feat”**, **“fix”**, **“refactor”**, **“style”**, **“docs”**, **“test”**, **“perf”**,
**“build”**, **“ci”** e **“revert”**

#### feat

`feat` são quaisquer adições ao código.

Enquanto elas podem alterar parte do código já existente, o foco dela é a implementação de “features” novas ao
ecossistema ou incrementos em “features” existentes.

Exemplos:

Acréscimo de um serviço, funcionalidade, endpoint, etc.

`feat: allow provided config object to extend other configs`

`feat(lang): add polish language`

`feat(login): insert domain validation on the login screen`

`feat(routes): add click functions on map markers`

#### fix

`fix` refere-se às correções de “bugs”. Uma correção em documentos, testes, build ou scripts ci não deve ser considerada
do tipo fix.

Exemplos:

Aplicar tratativa para uma função que não está tendo o comportamento esperado e retornando erro.

`fix(login): fix description property of the email field`

`fix(dashboard): fix decimal point error`

`fix(router): make router provides work with cli and offline compilation`

`fix: resolve shorthand property declarations`

#### refactor

`refactor` refere-se a quaisquer mudanças que atinjam o código, porém não alterem sua funcionalidade.

Alterou o formato de como é o processamento em determinada parte da sua tela, mas manteve a mesma funcionalidade?
Declare como “refactor”.

Exemplos:

Remoção de código redundante, simplificação do código, renomeação de variáveis, alterações de código após uma revisão de
código, etc.

`refactor: remove redundat styles`

`refactor: remove deprecated bootstrap`

`refactor(core): simplify and cleanup reflection`

`refactor: change from anonymous functions to arrow function on container config`

#### style

Alterações referentes a formatações de código, “semicolons”, “trailing spaces” e “lint” em geral são em `style`.

Exemplos:

Indentações, remover espaços em brancos, remover comentários, etc.

`style(login): insert blank line at the end of login.php file`

`style(core): fix max line length to pass linting`

`style: add space between .home and hamburger`

`style: use single quotes consistently`

#### docs

Com `docs`, temos conteúdo relativo à documentação.

Será usado ao adicionar comentários no código, “phpdoc”, “jsdoc”, “storyboard” e tudo que não interfira no código, porém
indique o funcionamento do mesmo.

Exemplos:

Adicionar informações na documentação da API, mudar o “README”, etc.

`docs(login): adiciona jsdoc às funções`

`docs(readme): insere subseção código de conduta ao README`

#### test

`test` será usado ao realizar commits relacionados às modificações e adições aos testes unitários e/ou “end-to-end”.

Exemplos:

Criação ou modificação de testes unitários.

`test(login): fix unit tests on the validator class`

`test(dashboard): add e2e test`

`test: add test for missingTranslation parameter`

`test: add attribute interpolation test`

#### perf

`perf` será usado para indicar uma alteração que melhorou a performance do sistema.

Exemplos:

Remover código lento, melhorar a query do graphQL, etc.

`perf: change ForEach to while in the item filter`

`perf(dashboard): improve graphQL query`

`perf: avoid unnecessary I/O operation in ng-packages-installer`

`perf: remove check for function type in renderStringify`

#### build

`build` será utilizada para indicar mudanças que afetam o processo de “build” do projeto ou dependências externas.

Exemplos:

Adicionar/remover dependências do npm, editar “scripts” do package.json, etc.

`build: adiciona dependência mm-cz-conventional-changelog`

`build: change license type in package.json`

`build(npm): update fsevents to 1.0.14`

`build(docs-infra): enable ServiceWorker in cli config`

#### ci

`ci` será utilizada para informar mudanças nos arquivos de configuração de CI.

Exemplos:

Github Actions, Git hooks, CircleCI, Travis, Jenkins etc.

`ci: add payload size limit file`

`ci: re-use setup CircleCI job in aio_monitoring`

`ci: implement unit test triggering in github actions`

`ci: add pre-push git hook`

#### revert

Se o commit reverter um commit anterior, ele deve começar com `revert`, seguido pelo cabeçalho do commit revertido.

No corpo, deve-se dizer `this reverts commit <hash>`, onde o “hash” é o **SHA** do commit que está sendo revertido.

Exemplo:

`revert: reverte commit 74a9ef`

### Escopo

Escopos podem ser quaisquer partes do projeto;
é importante que eles sejam compreendidos de uma maneira quase automática para alguém que não conhece o projeto.
Em geral, a utilização do escopo é bem genérica, especificando apenas o primeiro contexto (login, middleware, profile).
No entanto, prefira ser mais específico e defina um segundo escopo (containers/login, por exemplo).

Supondo que você tenha feito uma refatoração nas rotas relativas as configurações do projeto, uma possibilidade de
commit seria:

`feat(routes/settings): adjust settings to be called in any screen`

### Descrição

As descrições devem ser suficientemente claras, utilizando seu espaço até o máximo permitido da linha. Caso você veja
que a explicação não foi suficiente, sinta-se à vontade para adicionar conteúdo ao corpo.

**1. Deve conter a descrição sucinta da alteração:**

Tente comunicar o que o commit faz sem que seja necessário olhar o conteúdo do commit.

**2. Use o imperativo:**

Use o modo imperativo na 3ª pessoa do singular: "corrige" e não "corrigiu", "corrigindo" ou "correção".

Por quê!?

A mensagem de commit diz o que ele **faz**, não o que foi feito.

Regrinha de ouro para mensagens:

**Uma descrição de commit devidamente formada deve sempre ser capaz de completar a seguinte frase:**

- Se aplicado, este commit ...

Por exemplo:

- Se aplicado, este commit _refatora o subsistema X para facilitar a leitura_
- Se aplicado, este commit _atualiza a documentação de primeiros passos_
- Se aplicado, este commit _remove métodos obsoletos_
- Se aplicado, este commit _atualiza versão para 1.0.0_
- Se aplicado, este commit _mescla solicitação #123 de user/branch_

Observe como isso não funciona para as outras formas não imperativas:

- Se aplicado, este commit _bug corrigido com Y_
- Se aplicado, este commit _mudando o comportamento de X_
- Se aplicado, este commit _mais correções para coisas quebradas_
- Se aplicado, este commit _lindos novos métodos de API_

_Lembre-se: o uso do imperativo é importante apenas na linha de descrição. Você pode ignorar essa restrição ao escrever
o corpo._

**3. Limite a linha de descriçao a 50 caracteres.**

Manter as descrições de commit nesse tamanho garante que elas sejam legíveis e força o autor a pensar por um momento
sobre a maneira mais concisa de explicar o que está acontecendo.

_Dica: se estiver com dificuldade para resumir, você pode estar realizando muitas alterações de uma vez. Esforce-se
por [commits atômicos](https://www.freshconsulting.com/atomic-commits/)._

A IU do GitHub está totalmente ciente dessas convenções. Ele irá avisá-lo se você ultrapassar o limite de 50 caracteres
e truncará qualquer linha de assunto com mais de 72 caracteres com reticências. Portanto, busque 50 caracteres, mas
considere 72 como limite máximo.

**3. Comece a frase com uma letra minúscula**

Isto é tão simples quanto parece. A razão para escolher começar com uma letra minúscula é simplesmente aderir ao
[@commitlint/config-conventional](https://github.com/conventional-changelog/commitlint/tree/master/%40commitlint/config-conventional).

**4. Sem ponto (.) no final.**

A pontuação final é desnecessária nas descrições. Além disso, o espaço é precioso quando você tenta mantê-los com 50
caracteres ou menos.

## Corpo

O corpo, por sua vez, deve conter descrições mais precisas do que está contido naquele commit, mostrando as razões ou
consequências geradas por esse código, assim como instruções futuras.

**Use o corpo da mensagem para explicar "porquê", "para quê" e detalhes adicionais, mas não o "como".**

```
# Bom
fix: corrige o nome dp método das classes filhas de InventoryBackend

As classes derivadas do Inventory Backend não respeitavam a interface da
classe base.

Funcionava anteriormente porque o carrinho estava chamando a
implementação incorretamente.
```

```
# Bom
refactor: adiciona o método `use` na classe Credit

Alterado de namedtuple para classe porque nós precisamos
configurar um novo atributo (in_use_amount) com um novo valor.
```

O título e o corpo da mensagem são separados por uma linha em branco. Linhas em branco adicionais são consideradas como
parte do corpo.

Caracteres como `-`, `*` e `'` são elementos comuns para melhorar a leitura.

Na maioria dos casos, você pode omitir detalhes sobre como uma alteração foi feita. O código geralmente é
autoexplicativo nesse aspecto (e se o código for tão complexo que precise ser explicado, é para isso que servem os
comentários no próprio código). Concentre-se apenas em deixar claro os motivos pelos quais você fez a mudança em
primeiro lugar - a maneira como as coisas funcionavam antes da mudança (e o que havia de errado com isso), a maneira
como funcionam agora e por que você decidiu resolver o problema da maneira que fez.

O futuro mantenedor que irá lhe agradecer pode ser você mesmo!

## Rodapé

O rodapé restringe-se às alterações de estado via **“smart commit”**, como resoluções de estado de “issues”.
A idéia é que no futuro seja possível com **“smart commits”** associar o commit a uma “issue” do Jira e alterar seu
estado automaticamente com keywords como `comment`, `close`, `time`.

Exemplo: CRBU-1984 #time 1h #close #comment Problema resolvido.

## Recomendações

**Evite commits com mensagens genéricas ou sem contexto algum**

```
# Ruim
fix this

fix stuff

agora vai

change stuff
adjust css
```

**Tente limitar o nº de colunas das mensagens**

[Recomenda-se](https://git-scm.com/book/en/v2/Distributed-Git-Contributing-to-a-Project#_commit_guidelines) 50
caracteres para o título e por volta de 72 para o corpo.

**Dica**: Configure seu editor([nano¹](http://stackoverflow.com/a/31844714),
[Vim²](https://robots.thoughtbot.com/5-useful-tips-for-a-better-commit-message)) para quebrar a linha em 72 caracteres.

### Mantenha consistência de idioma

```
# Bom
ababab refactor: add `use` method to Credit model
efefef refactor: use InventoryBackendPool to retrieve inventory backend
bebebe fix: fix method name of InventoryBackend child classes
```

```
# Bom
ababab refactor: adiciona o método `use` ao model Credit
efefef refactor: usa o InventoryBackendPool para recuperar o backend de estoque
bebebe fix: corrige nome de método na classe InventoryBackend
```

```
# Ruim
ababab refactor: agregue el método "use" al modelo de crédito
efefef refactor: usa o InventoryBackendPool para recuperar o backend de estoque
bebebe fix: fix method name of InventoryBackend child classes
```

### Breaking Change

Se existir uma mudança drástica que quebrará funcionalidades, você **DEVE** obrigatóriamente indicar no corpo com
**‘BREAKING CHANGE’** (sim, em caixa alta) e explicar as razões que levaram a essa marcação.

## Notas

1. [nano](https://www.nano-editor.org/)
2. [vim](https://www.vim.org/)

## Referências

1. [Contributing to Angular](https://github.com/angular/angular/blob/main/CONTRIBUTING.md#commit)
2. [Karma - Git Commit Msg](http://karma-runner.github.io/1.0/dev/git-commit-msg.html)
3. [Chris Beams - How to Write a Git Commit Message](https://cbea.ms/git-commit/)
4. [tbaggery - A Note About Git Commit Messages](https://tbaggery.com/2008/04/19/a-note-about-git-commit-messages.html)
5. [conventional-changelog/commitlint](https://github.com/conventional-changelog/commitlint/tree/master/%40commitlint/config-conventional)
6. [Git - Commit Guidelines](https://git-scm.com/book/en/v2/Distributed-Git-Contributing-to-a-Project#_commit_guidelines)
7. [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/)
8. [Spring framework - Format commit messages](https://github.com/spring-projects/spring-framework/blob/30bce7/CONTRIBUTING.md#format-commit-messages)

# <img src="public/assets/images/espanha.png" alt="Spain flag" style="height: 36px; width:36px; margin-bottom: -7px;"/> Patrón de Commit

**TODO**
