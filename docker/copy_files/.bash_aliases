# global aliases
alias rm='rm -i'
alias cp='cp -i'
alias mv='mv -i'
alias ls='ls --color=auto'
alias ll='ls -lA'
alias grep='grep --color=auto'

# project aliases
alias pbc='php bin/console'
alias rmc='rm -rf var/cache; echo var/cache removed'
alias cc='rm -rf var/cache; php bin/console cache:clear; echo var/cache removed \& cache cleared'
alias pu='./vendor/bin/phpunit'
alias puf='./vendor/bin/phpunit --filter'
