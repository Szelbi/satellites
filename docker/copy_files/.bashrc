# .bashrc

#PS1
project_name=$(grep 'PROJECT_NAME' .env | cut -d'=' -f2)

if [ $(id -u) -eq 0 ];
then
    PS1="\[\033[36m\]\u\[\033[m\]@\[\033[32m\]\h($project_name):\[\033[33;1m\]\w\[\033[m\]\$ "
else
    PS1="[\\u@\\h:\\w] $"
fi

# custom user aliases
if [ -f ~/.bash_aliases ]; then
    . ~/.bash_aliases
fi
