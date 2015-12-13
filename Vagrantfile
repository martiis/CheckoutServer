# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box_check_update = false
  config.vm.synced_folder ".", "/vagrant", type: "nfs"

  config.vm.provider "virtualbox" do |vb|
    vb.gui = false
    vb.memory = "512"
    vb.cpus = 1
  end

  config.vm.define "rest" do |rest|
    rest.vm.box = "ubuntu/trusty64"
    rest.vm.network "private_network", ip: "192.168.33.10"
    rest.vm.network "forwarded_port", guest: 80, host: 8000
    rest.vm.synced_folder "./rest", "/vagrant", type: "nfs"
  end

  config.vm.define "soap" do |soap|
    soap.vm.box = "ubuntu/trusty64"
    soap.vm.network "private_network", ip: "192.168.33.11"
    soap.vm.network "forwarded_port", guest: 80, host: 8001
    soap.vm.synced_folder "./soap", "/vagrant", type: "nfs"
  end

  config.vm.provision "shell", inline: <<-SHELL
     sudo apt-get update
     sudo apt-get -y install language-pack-en nginx php5-fpm php5-cli php5-json php5-curl curl git-core htop nano
     locale-gen UTF-8
     curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
  SHELL
end
