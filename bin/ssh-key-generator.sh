#!/usr/bin/env bash

if [ $# -lt 2 ]; then
  echo "Provide email and hostname"
  exit 1
fi

email="$1"
hostname="$2"
keypath="$HOME/.ssh/${hostname}_rsa"
ssh-keygen -t ed25519 -C "$email" -f "$keypath"

if [ ! $? -eq 0 ]; then
  echo "Error when running ssh-keygen"
  exit 1
fi

exit 0
cat >> "$HOME"/.ssh/config-test <<EOF
Host $hostname
        Hostname $hostname *.$hostname
        User git
    IdentitiesOnly yes
        IdentityFile $keypath
EOF
