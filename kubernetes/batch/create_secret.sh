kubectl create secret generic git-secret -n bibliopro \
    --from-file=ssh=deploy \
    --from-file=known_hosts=deploy.hosts