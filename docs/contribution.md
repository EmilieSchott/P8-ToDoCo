# Contribution

---

## 1. Add modifications to the project

To propose modifications to the application, you should install [Git](https://git-scm.com/downloads) on your computer and have a [github account](https://github.com/).

### A.Configure Git

Don't forget to configure Git :

- Indicate your identity :
  - "_git config --global user.name 'John Doe'_"
  - "_git config --global user.email 'john.doe@example.com'_"
- Improve lisibility by activate colors, by typing:
  - "_git config --global color.diff auto_"
  - "_git config --global color.status auto_"
  - "_git config --global color.branch auto_"
- Indicate an editor :
  - "_git config --global core.editor editor-name_"
  - or "_git config --global core.editor "'path\to\editor.exe' -w_"
- We strongly recommand to install [Meld](https://meldmerge.org/) too and configure Git to use it, by typing :
  - to merge : "_git config --global merge.tool meld_"
  - to see differences : "_git config --global diff.tool meld_"
  - (on windows 10, you should indicate path to meld executable too by typing : "_git config --global merge.tool.path 'C:\your\path\to\Meld.exe'_")

### B. Install the project on your computer

See [README.md](../README.md)

### C. Commit your work with Git

Commit your modifications allow you to keep trace of the modifications and to go back in case of error.

- Run Git on your computer
- Place yourself in the project repository (use "cd" command)
- Control the existant branches in the project : "_git branch_"
  - If the feature branch on which you want to work allready exists : "_git checkout feature-branch-name_"
  - If you should create a branch for a new feature:
    - Place yourself on the branch "_develop_" : "_git checkout develop_"
    - Create a branch for your feature and place yourself on it by typing : "_git checkout -b new-feature-branch-name_" (usually, branch name is formated like this : "_feature/purpose_of_the_feature_")
- After modifications, add all the files you modified to stage by typing "_git add ._"
- Create a commit to register your modifications to these files by typing "_git commit_", then write a comment in the editor to explain what you did, on the first line.

### D. Push your code on Github

- The first time you want to push something on the remote repository, place yourself in the project repository with "_Git_" (use "_cd_" command) and create a link between your computer and the remote repository by typing : "_git remote add origin htpps://github.com/project-url_"
  ("_origin_" is the conventional name for a remote repository but you can named it as you wish. Just make sure to remember it.)

- The first time you want to push a branch on the remote repository, you should create a branch on the remote repository where to send your feature branch by typing : "_git push --set-upstream origin branch-name-on-remote-repository_"
  (Usually the name on the remote repository is the same as the one on the local repository)

- The next times you should simply type : "_git push_" to push your code on "_Github_"

### E. Make a pull request

When your feature is complete and you push your last commits on the remote repository, you should make a pull request to ask your peer to review your code before merge it in develop branch.

On github:

- go to the project page
- Click on Pull request tab
- click on the "_New pull request_" green button on the right.
- choose :
  - the branch where you want to merge yours (develop)
  - the branch to merge in (your branch)
- Then click on "_Create pull request_" green button on the right
- Leave a message to your peers ans click on the publish button.
- wait for codacy analysis results. If something wrong correct your code and push it again (see below for further informations)
- when the branch is validated (you'll see a green check icon next to the reviewer name in the right panels named "_Reviewers_"), click on "_Merge pull request_" green button at the bottom of the page.
- click on "_Delete branch_" button

### F. Pull modifications into your local repository

Each morning, before start to worfk, you should retrieve project modifications :

- on "_develop_" branch
- on the branch you work on.

To do so, in Git, you should for these two branches :

- Place yourself on the branch by typing : "_git checkout branch-name_"
- control than your local branch is uptodate with remote repository by typing : "_git log_" and check if the HEAD and the remote branch are on the same commit.
  If the remote branch are some additional commits, you should :

  - Control branch compatibility by typing "_git fetch_"
  - Then, download branch modifications by typing "_git pull_"

If the branch you just pull from is "_develop_" :

- if the commit pulled is a merge from an other branch (see "_git log_" results), don't forget to delete the branch on your local repository : "_git branch -d merged-branch-into-develop-name_"
- If you are allready working on an other branch, don't forget to rebase. For that:
  - place yourself on your working branch : "_git checkout working-branch-name_"
  - Then typing : "_git rebase develop_"
  - Resolve conflicts :
    - when a conflict shows up, type : "_git mergetool_"
    - in the center choose the code you want to save
    - Save and close the mergetool
    - Control the code and if all is alright delete "_file-modified.ext.orig_"
    - control if some modifications sould be committed : "_git status_"
    - if so, staged it : "_git add ._" then commit "_git commit_" with a comment.
    - Then, pursue rebase by typing "_git rebase --continue_"
    - And so on until rebase end.
    - Push the branch uptodate on remote repository with : "_git push --force-with-lease_"

---

## 2. Quality process

To guarantee the application quality, you should :

### A. Before development

- **Install tools for code quality in your IDE**  
  like "_php-cs-fixer_", "_intelephense_" for "_VSCode_". These extensions will check your code to ensure code quality.

- **Know the PSRs**
  These tools recommanded helps to respect standards but you need to know about them too :
  - [PSR-1 : Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)
  - [PSR-4 : Autoloading Standard](https://www.php-fig.org/psr/psr-4/)
  - [PSR-12 : Extended Coding Style Guide](https://www.php-fig.org/psr/psr-12/)

### B. During development

- **Perform already writen tests for existant features**
  Some tests for existant features already exists in the application. When you modify something in the code, you should allways perform all unit and functional tests existant to be sure the application still work.
  If you don't know how, please, see the [tests documentation](./docs/tests.md).

- **Write tests for new features**
  When you create a new feature, you should write new tests to check if your code is functionnal.
  To write :
  - unit tests, please read [PHPUnit documentation](https://phpunit.readthedocs.io/fr/latest/index.html)
  - functional tests, please read :
    - [Behat documentation](https://docs.behat.org/en/v3.0/user_guide.html)
    - [Mink documentation](http://mink.behat.org/en/latest/)

### C. After development of a branch

- **Perform a _Blackfire_ analysis to control that your code doesn't slow down the application**
  ([Install Blackfire](https://blackfire.io/docs/up-and-running/installation), if it's not allready done.)
  For this you should :

  - be sure to be logged in on [Blackfire website](https://blackfire.io/login)
  - be sure to be on the branch you want to submit for a pull request in git.
  - In a CLI, don't forget to run Blackfire Agent by typing : "_blackfire agent:start_"
  - to avoid to significantly slow down the application, don't forget :
    - to disable Xdebug before perform _Blackfire_ analysis, in your php version folder, find php.ini file and replace the line `extension_zend = xdebug` by `;extension_zend = xdebug` (to add a ; before the line comments it)
    - to switch application in production environment by opening the application page with the adress : "https://your-website/app.php" in your browser.
  - In your browser, open the application page and click on the blackfire icon on the right of the browser adress bar.
  - Name the generated profile in _Blackfire_ toolbar.
  - click on the icon in the Blackfire toolbar to acces the generated profile.
    You can now compare the precedent profile of the page you want with the one you just generate. (click on the "compare" button at the profiles right you want to compare in the right order)

- **Take account of _Codacy_ analysis results**
  When a Pull request is submit, a _Codacy_ analysis is automotically performed. Check the results and if something wrong, correct your code and push the new commit on the remote repository.

---
