#!/bin/bash 

# Nous devons installer les dépendances uniquement pour Docker
 [[ ! -e /.dockerenv ]] && exit 0 
apt-get update -qq \ 
&& apt-get install -qq git \ 
  # Configurer les clés de déploiement SSH
 && 'quel ssh-agent || ( apt-get install -qq openssh-client )' \ 
&& eval $(ssh-agent -s) \ 
&& ssh-add <(echo "$SSH_PRIVATE_KEY") \ 
&& mkdir -p ~/.ssh \ 
&& '[[ -f /.dockerenv ]] && echo -e "Host *\n\tStrictHostKeyChecking no\n\n" > ~/.ssh/config'