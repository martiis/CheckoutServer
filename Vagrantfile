# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.box_check_update = false
  config.vm.network "forwarded_port", guest: 80, host: 8000
  config.vm.network "private_network", ip: "192.168.33.10"
  config.vm.synced_folder ".", "/vagrant"

  config.vm.provider "virtualbox" do |vb|
     vb.gui = false
     vb.memory = "1024"
     vb.cpus = 1
  end

  config.vm.provision "shell", inline: <<-SHELL
     locale-gen UTF-8
     echo "deb http://www.rabbitmq.com/debian/ testing main" > /etc/apt/sources.list.d/rabbitmq.list
     wget https://www.rabbitmq.com/rabbitmq-signing-key-public.asc
     apt-key add rabbitmq-signing-key-public.asc
     sudo apt-get update
     sudo apt-get -y install php5-cli php5-json php5-curl curl git-core htop nano rabbitmq-server
     curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
     rabbitmq-plugins enable rabbitmq_management
     rabbitmqctl delete_user guest
     rabbitmqctl add_user user user
     rabbitmqctl set_user_tags user administrator management
     rabbitmqctl set_permissions -p / user ".*" ".*" ".*"
  SHELL
end
