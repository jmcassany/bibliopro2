# Create cluster without traefik
clustercreate:
#	k3d cluster create --k3s-server-arg "--disable=traefik" --k3s-server-arg "--disable=servicelb"
	k3d cluster create --k3s-server-arg "--disable=traefik"

clusterdelete:
	k3d cluster delete

bibliopro:
	helmfile --file bibliopro/bibliopro-helmfile.yaml apply

php:
	helmfile --file php/php-helmfile.yaml apply

mysql:
	helmfile --file mysql/mysql-helmfile.yaml apply

traefik:
	helmfile --file traefik/traefik-helmfile.yaml apply