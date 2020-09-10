export KUBECONFIG=~/.k3d/kubeconfig-default.yaml
.PHONY: status

allinit: status status/init_done

status: 
	mkdir -p status  

status/cluster_init.txt:
	touch status/cluster_init.txt

status/cluster_done.txt: status/cluster_init.txt
	k3d cluster create default -a 2
	touch status/cluster_done.txt

deletecluster:
	k3d cluster delete default
	rm -rf status


status/config_done.txt: status/cluster_done.txt
	KUBECONFIG=~/.k3d/kubeconfig-default.yaml k3d kubeconfig merge default
	touch status/config_done.txt

# aquí instalem els scripts helm que permeten instal·lar aplicacions ja predefinides al Kubernetes
status/helm_done.txt: status/config_done.txt
	KUBECONFIG=~/.k3d/kubeconfig-default.yaml helm repo add stable https://kubernetes-charts.storage.googleapis.com/
	KUBECONFIG=~/.k3d/kubeconfig-default.yaml helm repo update
	KUBECONFIG=~/.k3d/kubeconfig-default.yaml helm search repo stable
	touch status/helm_done.txt
# aquí instal·lem un servidor nfs dins de Kubernetes que ens permet crear carpetes amb ReadWriteMany
status/nfs_done: status/helm_done.txt
	KUBECONFIG=~/.k3d/kubeconfig-default.yaml helm install nfs-server stable/nfs-server-provisioner --set persistence.enabled=true,persistence.size=60Gi,storageClass.mountOptions={vers\=4}
	touch status/nfs_done

status/images_done: $(wildcard docker/*)
	$(MAKE) -C docker
	$(MAKE) -C kubernetes/dbdump
	touch status/images_done
	
status/loadimages_done: status/images_done status/nfs_done
	k3d image import -c default registry.io.imim.cloud/bibliopro:1.2
	k3d image import -c default registry.io.imim.cloud/bibliopro:1.2
	touch status/loadimages_done

push: 
	$(MAKE) -C docker push 
	$(MAKE) -C kubernetes/dbdump push

nodes:
	KUBECONFIG=~/.k3d/kubeconfig-default.yaml kubectl get nodes

status/init_done: status/loadimages_done $(wildcard kubernetes/*)
	KUBECONFIG=~/.k3d/kubeconfig-default.yaml kubectl apply -f kubernetes -n bibliopro || \
	touch status/init_done

get:
	KUBECONFIG=~/.k3d/kubeconfig-default.yaml kubectl get all -n bibliopro

run:
	kubectl port-forward service/bibliopro -n bibliopro 8080:80


build:
	$(MAKE) -C docker:

wait:
	kubectl wait --for=condition=ready pod -l app=bibliopro -n bibliopro
	kubectl wait --for=condition=running pod -l app=bibliopro -n bibliopro

