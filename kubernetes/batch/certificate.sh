kubectl -n bibliopro delete secret biblioprocom
kubectl -n bibliopro create secret tls biblioprocom --key=bibliopro.com.key --cert=bibliopro.com.crt
kubectl -n traefik delete secret biblioprocom
kubectl -n traefik create secret tls biblioprocom --key=bibliopro.com.key --cert=bibliopro.com.crt