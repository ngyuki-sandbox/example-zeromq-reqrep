Vagrant.configure(2) do |config|

  config.vm.box = "bento/centos-7.2"

  config.vm.provision "shell", inline: <<-SHELL
    sudo yum -y install epel-release
    sudo yum -y install php php-mbstring php-process \
        gcc php-devel php-pear gcc \
        zeromq zeromq-devel

    sudo pecl install channel://pecl.php.net/zmq-1.1.3
    echo 'extension=zmq.so' | sudo tee /etc/php.d/zmq.ini

    curl -sS https://getcomposer.org/installer |
      sudo php -- --install-dir=/usr/local/bin --filename=composer
  SHELL

  config.vm.provider :virtualbox do |v|
    v.linked_clone = true
  end
end
