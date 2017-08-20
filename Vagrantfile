# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'yaml'

ANSIBLE_PATH = __dir__
ANSIBLE_PATH_ON_VM ='/home/vagrant/realworldio'

dev_config = YAML.load_file("#{ANSIBLE_PATH}/vagrant.default.yml")

if File.exist?("#{ANSIBLE_PATH}/vagrant.local.yml")
  local_config = YAML.load_file("#{ANSIBLE_PATH}/vagrant.local.yml")
  dev_config.merge!(local_config) if local_config
end

def fail_with_message(msg)
  fail Vagrant::Errors::VagrantError.new, msg
end

Vagrant.require_version '>= 1.8.0'

Vagrant.configure(2) do |config|
  config.vm.box = "bento/ubuntu-16.04"
  config.ssh.forward_agent = true

  # Required for NFS to work, pick any local IP
  config.vm.network :private_network, ip: '192.168.100.10'

  config.vm.hostname = 'realworldio.brookjs.dev'

  if !Vagrant.has_plugin? 'vagrant-hostsupdater'
    fail_with_message "vagrant-hostsupdater missing, please install the plugin with this command:\nvagrant plugin install vagrant-hostsupdater"
  end

  if !Vagrant.has_plugin? 'vagrant-bindfs'
    fail_with_message "vagrant-bindfs missing, please install the plugin with this command:\nvagrant plugin install vagrant-bindfs"
  end

  config.vm.synced_folder ANSIBLE_PATH, ANSIBLE_PATH_ON_VM, type: 'nfs'

  config.bindfs.bind_folder ANSIBLE_PATH_ON_VM, "/srv/www/realworldio/current", u: 'vagrant', g: 'www-data', o: 'nonempty'

  # Give VM access to all cpu cores on the host
  cpus = case RbConfig::CONFIG['host_os']
    when ENV['NUMBER_OF_PROCESSORS'] then ENV['NUMBER_OF_PROCESSORS'].to_i
    when /darwin/ then `sysctl -n hw.ncpu`.to_i
    when /linux/ then `nproc`.to_i
    else 2
  end

  # Give VM more memory
  # This may be a lot more memory than necessary,
  # but Hybris does take a lot.
  memory = dev_config["host_memory"]

  config.vm.provider 'virtualbox' do |vb|
    # Customize  VM settings
    vb.customize ['modifyvm', :id, '--cpuexecutioncap', '70']
    vb.customize ['modifyvm', :id, '--memory', memory]
    vb.customize ['modifyvm', :id, '--cpus', cpus]

    # Fix for slow external network connections
    vb.customize ['modifyvm', :id, '--natdnshostresolver1', 'on']
    vb.customize ['modifyvm', :id, '--natdnsproxy1', 'on']
  end

  config.vm.provision :ansible_local do |ansible|
    ansible.install_mode = 'pip'
    ansible.provisioning_path = ANSIBLE_PATH_ON_VM

    ansible.playbook = File.join(ANSIBLE_PATH_ON_VM, 'dev.yml')
    ansible.galaxy_role_file = File.join(ANSIBLE_PATH_ON_VM, 'requirements.yml')
    ansible.galaxy_roles_path = File.join(ANSIBLE_PATH_ON_VM, 'roles', 'vendor')

    ansible.groups = {
        'web' => ['default'],
        'development' => ['default']
    }
  end
end
