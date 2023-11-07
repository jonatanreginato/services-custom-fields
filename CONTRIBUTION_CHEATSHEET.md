#### 1. Lembre de configurar suas credenciais no git:

```
$ git config --global user.name "YOUR GIT NAME"
$ git config --global user.email "YOUR EMAIL ADDRESS"
```

#### 2. O fluxo se inicia com o clone do repositório oficial para a sua máquina de desenvolvimento:

```
$ git clone git@github.com:path/to/repo.git
```

#### 3. Crie seu branch:

```
$ git checkout main
$ git reset --hard origin/main
$ git fetch origin --prune
$ git merge
$ git checkout -b <your-branch-name>
```

#### 4. Registre as suas alterações:

```
$ git add -A
$ git commit
```

#### 5. Envie suas alterações para o branch remoto:

```
$ git push --set-upstream origin <your-branch-name>
```

#### 6. Atualize seu branch com o repositório remoto antes de enviar um pull request:

```
$ git checkout main
$ git reset --hard origin/main
$ git fetch --all
$ git merge
$ git checkout <your-branch-name>
$ git rebase staging
$ git push -f
```

#### 7. Faça o *[pull request](https://github.com)* para o repositório remoto:
