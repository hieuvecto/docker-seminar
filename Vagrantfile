# -*- mode: ruby -*-
# vi: set ft=ruby :
Vagrant.configure(2) do |config|
  
  # config.vm.box = "bento/centos-7.4"
  # config.vm.box_version = "201802.02.0"

  server_configs = [
    {"hostname" => "app", "ip" => "192.168.33.25", "memory_size" => "512", "install_docker" => true },
    {"hostname" => "database", "ip" => "192.168.33.26", "memory_size" => "512", "install_docker" => true },
  ]

  server_configs.each do |server_config|
    config.vm.define "#{server_config['hostname']}" do |server|
      server.vm.hostname = server_config['hostname']
      server.vm.box = "bento/centos-7.4"
      server.vm.box_version = "201803.24.0"
      server.vm.network :private_network, ip: server_config['ip']
      # server.vm.network :forwarded_port, guest: 22, host: server_config['port'], id: "ssh"
      server.vm.provider "virtualbox" do |v|
        v.customize ["modifyvm", :id, "--memory", server_config['memory_size']]
        # v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
        # v.customize ["setextradata", :id, "VBoxInternal/Devices/VMMDev/0/Config/GetHostTimeDisabled", 0]
      end
    
      server.vm.synced_folder '.', '/vagrant', disabled: true

      if server_config['install_docker'] then
        server.vm.provision :shell, path: "scripts/install_docker.bash"
      end

      if server_config['hostname'] === 'app' then
        server.vm.synced_folder './app', '/home/vagrant/app', owner: "vagrant", group: "vagrant", create: true, mount_options: ["dmode=770,fmode=770"]
        server.vm.synced_folder './app/code', '/usr/share/code', owner: "root", group: "root", create: true, mount_options: ["dmode=775,fmode=777"]
        server.vm.synced_folder './app/php-fpm/log', '/usr/share/log', owner: "root", group: "root", create: true, mount_options: ["dmode=775,fmode=777"]
        server.vm.synced_folder './app/php-fpm/config', '/usr/share/config', owner: "root", group: "root", create: true, mount_options: ["dmode=775,fmode=777"]
      end
      
      if server_config['hostname'] === 'database' then
        server.vm.synced_folder './database', '/home/vagrant/database', owner: "vagrant", group: "vagrant", create: true, mount_options: ["dmode=770,fmode=770"]
      end
      
    end
  end
end
  