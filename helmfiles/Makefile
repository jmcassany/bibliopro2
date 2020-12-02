# Create cluster without traefik
clustercreate:
#	k3d cluster create --k3s-server-arg "--disable=traefik" --k3s-server-arg "--disable=servicelb"
	k3d cluster create --k3s-server-arg "--disable=traefik"

clusterdelete:
	k3d cluster delete

bibliopro:
	helmfile --file helmfiles/bibliopro/bibliopro-helmfile.yaml apply

php:
	helmfile --file helmfiles/php/php-helmfile.yaml apply

mysql:
	helmfile --file helmfiles/mysql/mysql-helmfile.yaml apply

