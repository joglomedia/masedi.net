#!/bin/bash
# Quick and dirty OpenVPN install script
# Tested on Centos 5.x 32bit, openvz minimal CentOS OS templates
# Please submit feedback and questions at support@vpsnoc.com

# John Malkowski vpsnoc.com 01/04/2010

ip=`grep IPADDR /etc/sysconfig/network-scripts/ifcfg-venet0:0 | awk -F= '{print $2}'`

wget http://packages.sw.be/rpmforge-release/rpmforge-release-0.5.1-1.el5.rf.i386.rpm
rpm -iv rpmforge-release-0.5.1-1.el5.rf.i386.rpm
rm -rf rpmforge-release-0.5.1-1.el5.rf.i386.rpm

yum -y install openvpn openssl openssl-devel
cd /etc/openvpn/
cp -R /usr/share/doc/openvpn-2.0.9/easy-rsa/ /etc/openvpn/
cd /etc/openvpn/easy-rsa/2.0/
chmod +rwx *
. ../vars
./clean-all
source ./vars

echo -e "\n\n\n\n\n\n\n" | ./build-ca
clear
echo "####################################"
echo "Feel free to accept default values"
echo "Wouldn't recommend setting a password here"
echo "Then you'd have to type in the password each time openVPN starts/restarts"
echo "####################################"
./build-key-server server
./build-dh
cp keys/{ca.crt,ca.key,server.crt,server.key,dh1024.pem} /etc/openvpn/

clear
echo "####################################"
echo "Feel free to accept default values"
echo "This is your client key, you may set a password here but it's not required"
echo "####################################"
./build-key client1
cd keys/

client="
client
remote $ip 1194
dev tun
comp-lzo
ca ca.crt
cert client1.crt
key client1.key
route-delay 2
route-method exe
redirect-gateway def1
dhcp-option DNS 10.8.0.1
verb 3"

echo "$client" > $HOSTNAME.ovpn

tar czf keys.tgz ca.crt ca.key client1.crt client1.csr client1.key $HOSTNAME.ovpn
mv keys.tgz /root

opvpn='
dev tun
server 10.8.0.0 255.255.255.0
ifconfig-pool-persist ipp.txt
ca ca.crt
cert server.crt
key server.key
dh dh1024.pem
push "route 10.8.0.0 255.255.255.0"
push "redirect-gateway"
comp-lzo
keepalive 10 60
ping-timer-rem
persist-tun
persist-key
group nobody
daemon'

echo "$opvpn" > /etc/openvpn/openvpn.conf

echo 1 > /proc/sys/net/ipv4/ip_forward
iptables -t nat -A POSTROUTING -s 10.8.0.0/24 -o venet0 -j MASQUERADE
iptables-save > /etc/sysconfig/iptables
sed -i 's/eth0/venet0/g' /etc/sysconfig/iptables # dirty vz fix for iptables-save
echo "net.ipv4.ip_forward=1" >> /etc/sysctl.conf

/etc/init.d/openvpn start
clear

echo "OpenVPN has been installed
Download /root/keys.tgz using winscp or other sftp/scp client such as filezilla
Create a directory named vpn at C:\Program Files\OpenVPN\config\ and untar the content of keys.tgz there
Start openvpn-gui, right click the tray icon go to vpn and click connect
For support/bug reports email us at support@vpsnoc.com"