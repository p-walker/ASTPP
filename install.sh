#!/bin/bash
#
# ASTPP - Open Source Voip Billing
#
# Copyright (C) 2004, Aleph Communications
#
# ASTPP Team <info@astpp.org>
#
# This program is Free Software and is distributed under the
# terms of the GNU General Public License version 2.
############################################################

#################################
####  variables #################
#################################
#################################
TEMP_USER_ANSWER="no"
INSTALL_ASTPP="no"
ASTPP_SOURCE_DIR="/usr/src/ASTPP/"
ASTPP_HOST_DOMAIN_NAME="host.domain.tld"

ASTPP_USING_FREESWITCH="no"
ASTPP_USING_ASTERISK="no"
INSTALL_ASTPP_PERL_PACKAGES="no"
INSTALL_ASTPP_WEB_INTERFACE="no"

ASTPP_DATABASE_NAME="astpp"
FS_DATABASE_NAME="fs"
FSCDR_DATABASE_NAME="fscdr"

ASTPP_DB_USER="astppuser"

IPTABLES_SETUP_FOR_ASTPP="no"
ASTPP_SERVER_IP="8.8.8.8"

MYSQL_ROOT_PASSWORD=""
ASTPPUSER_MYSQL_PASSWORD=""


REGISTER_PROVIDER_TRUNK="no"
FIRST_PROVIDER_TRUNK="no"
FOLLOW_PROVIDER_TRUNK="no"
TRUNK_PROVIDER_NAME="myvoipprovider01"
TRUNK_USERNAME="username"
TRUNK_PASSWORD="password"
TRUNK_REALM="sip.sample.com"
TRUNK_PROXY="sip.sample.com"
TRUNK_REGISTER="false"





#################################
#################################
####  general functions #########
#################################
#################################

# task of function: ask to user yes or no
# usage: ask_to_user_yes_or_no "your question"
# return TEMP_USER_ANSWER variable filled with "yes" or "no"
ask_to_user_yes_or_no () {
	# default answer = no
	TEMP_USER_ANSWER="no"
	clear
	echo ""
	echo -e ${1}
	read -n 1 -p "(y/n)? :"
	if [ ${REPLY} = "y" ]; then
		TEMP_USER_ANSWER="yes"
	else
		TEMP_USER_ANSWER="no"
	fi
}

# Determine the OS architecture
get_os_architecture () {
	if [ ${HOSTTYPE} == "x86_64" ]; then
		ARCH=x64
	else
		ARCH=x32
	fi
}
get_os_architecture

# Linux Distribution CentOS or Debian
get_linux_distribution () {
	if [ -f /etc/debian_version ] ; then
		DIST="DEBIAN"
	elif [ -f /etc/redhat-release ] ; then
		DIST="CENTOS"
	else
		DIST="OTHER"
	fi
}
get_linux_distribution

# get ip of eth0
get_local_ip () {
LOCAL_IP=`ifconfig eth0 | head -n2 | tail -n1 | cut -d' ' -f12 | cut -c 6-`
}
get_local_ip

# set right time
set_right_time () {
echo "get the Time Right"
ntpdate pool.ntp.org
service ntpd start
chkconfig ntpd on
}
set_right_time

install_epel () {
# only on CentOS
	if [ ${ARCH} = "x64" ]; then
		rpm -Uvh http://download.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-7.noarch.rpm
	else
		rpm -Uvh http://download.fedoraproject.org/pub/epel/6/i386/epel-release-6-7.noarch.rpm
	fi
}

remove_epel () {
# only on CentOS
yum remove epel-release
}

# Generate random password (for MySQL)
genpasswd() {
	length=$1
	[ "$length" == "" ] && length=16
	tr -dc A-Za-z0-9_ < /dev/urandom | head -c ${length} | xargs
}

#################################
#################################
####  ASK SCRIPTS ###############
#################################
#################################





# Ask to install astpp
ask_to_install_astpp () {
	ask_to_user_yes_or_no "Do you want to install ASTPP?"
	if 	[ ${TEMP_USER_ANSWER} = "yes" ]; then
		INSTALL_ASTPP="yes"
		echo ""
		read -p "Enter fqdn example: ${ASTPP_HOST_DOMAIN_NAME}: "
		ASTPP_HOST_DOMAIN_NAME=${REPLY}
		echo "Your entered data as fqdm : ${ASTPP_HOST_DOMAIN_NAME}"
		read -n 1 -p "Press any key to continue ... "
		
		ask_to_user_yes_or_no "Do you want use FreeSwitch on ASTPP?"
		if 	[ ${TEMP_USER_ANSWER} = "yes" ]; then
			ASTPP_USING_FREESWITCH="yes"	
		else 
			ask_to_user_yes_or_no "Do you want use Asterisk on ASTPP?"
				if 	[ ${TEMP_USER_ANSWER} = "yes" ]; then
				ASTPP_USING_ASTERISK="yes"
				fi
		fi

		ask_to_user_yes_or_no "Do you want to install ASTPP PERL PACKAGES?"
			if [ ${TEMP_USER_ANSWER} = "yes" ]; then
				INSTALL_ASTPP_PERL_PACKAGES="yes"
			fi
		
		ask_to_user_yes_or_no "Do you want to install ASTPP web interface?"
			if [ ${TEMP_USER_ANSWER} = "yes" ]; then
				INSTALL_ASTPP_WEB_INTERFACE="yes"
			fi
		
		
	fi
}
ask_to_install_astpp


# Ask IPTABLES setup for astpp
ask_iptables_setup_for_astpp () {
	ask_to_user_yes_or_no 	"Do you want to setup template IPTABLES for ASTPP?"
	if 	[ ${TEMP_USER_ANSWER} = "yes" ]; then
		IPTABLES_SETUP_FOR_ASTPP="yes"
		echo ""
		read -p "Enter ASTPP ip adress: ${ASTPP_SERVER_IP}: "
		ASTPP_SERVER_IP=${REPLY}
		echo "Your entered data as fqdm : ${ASTPP_SERVER_IP}"
		read -n 1 -p "Press any key to continue ... "
		
		
	fi
}
#ask_iptables_setup_for_astpp


# Ask Register freeswitch trunk
ask_register_freeswitch_provider_trunk () {
	ask_to_user_yes_or_no 	"Do you want to register a Provider on FreeSwitch?"
	if 	[ ${TEMP_USER_ANSWER} = "yes" ]; then
		REGISTER_PROVIDER_TRUNK="yes"
		echo ""
		
			ask_to_user_yes_or_no 	"Is this provider first provider you going add to Freeswitch"
			if 	[ ${TEMP_USER_ANSWER} = "yes" ]; then
				FIRST_PROVIDER_TRUNK="yes"
				FOLLOW_PROVIDER_TRUNK="no"
			else
				FIRST_PROVIDER_TRUNK="no"
				FOLLOW_PROVIDER_TRUNK="yes"
			fi
			echo ""
		
		clear
		read -p "Enter provider name e.g. : ${TRUNK_PROVIDER_NAME}: "
		TRUNK_PROVIDER_NAME=${REPLY}
		echo ""
		echo "Your entered data : ${TRUNK_PROVIDER_NAME}"
		read -n 1 -p "Press any key to continue ... "
		echo ""		
		
		clear
		read -p "Enter provider trunk username e.g.: ${TRUNK_USERNAME}: "
		TRUNK_USERNAME=${REPLY}
		echo ""
		echo "Your entered data : ${TRUNK_USERNAME}"
		read -n 1 -p "Press any key to continue ... "
		echo ""
		
		clear
		read -p "Enter provider trunk password e.g.: ${TRUNK_PASSWORD}: "
		TRUNK_PASSWORD=${REPLY}
		echo ""
		echo "Your entered data : ${TRUNK_PASSWORD}"
		read -n 1 -p "Press any key to continue ... "
		echo ""
		
		
		clear
		read -p "Enter provider trunk relam e.g.: ${TRUNK_REALM}: "
		TRUNK_REALM=${REPLY}
		echo ""
		echo "Your entered data : ${TRUNK_REALM}"
		read -n 1 -p "Press any key to continue ... "
		echo ""
		
		
		clear
		read -p "Enter provider trunk proxy e.g.: ${TRUNK_PROXY}: "
		TRUNK_PROXY=${REPLY}
		echo ""
		echo "Your entered data : ${TRUNK_PROXY}"
		read -n 1 -p "Press any key to continue ... "
		echo ""
		
		
			ask_to_user_yes_or_no 	"Need this trunk registration? "
			if 	[ ${TEMP_USER_ANSWER} = "yes" ]; then
				TRUNK_REGISTER="true"
			else
				TRUNK_REGISTER="false"
			fi
			echo ""
		
	fi
}
ask_register_freeswitch_provider_trunk






#################################
#################################
####  INSTALL SCRIPTS ###########
#################################
#################################

clear
echo -e "installation starting"
echo -e "are you ready?"
read -n 1 -p "Press any key to continue ... "
clear


# install freeswitch for astpp
install_freeswitch_for_astpp () {

install_epel

yum install -y git


yum clean all

# Install Freeswitch pre-requisite packages using YUM
yum install -y autoconf automake  expat-devel gnutls-devel libtiff-devel libX11-devel unixODBC-devel python-devel zlib-devel libzrtpcpp-devel alsa-lib-devel libogg-devel libvorbis-devel perl perl-libs gdbm-devel libdb-devel uuid-devel @development-tools gdbm-devel db4-devel libjpeg libjpeg-devel libtermcap libtermcap-devel ncurses ncurses-devel ntp screen sendmail sendmail-cf gcc-c++ libtool
apt-get -y install apache2 autoconf automake build-essential chkconfig dmidecode g++ gawk git-core git-core gnutls-bin libapache2-mod-php5 libncurses5 libjpeg62-dev libmyodbc libncurses5-dev libtool libtool libxml2 lua5.1 make bsd-mailx mysql-server php-apc php5 php5-gd php5-mcrypt php5-mhash php5-mysql pkg-config python-dev unixodbc-dev

# i think i need to install also next packages
yum install -y bison bzip2 curl curl-devel dmidecode git make mysql-connector-odbc openssl-devel unixODBC zlib

# Download latest freeswitch version
cd /usr/local/src
git clone git://git.freeswitch.org/freeswitch.git
cd freeswitch
./bootstrap.sh

read -n 1 -p "Press any key to continue ... "

# Edit modules.conf
echo "Enable mod_xml_curl, mod_xml_cdr, mod_perl (If you want to use calling card features)"

sed -i "s#\#xml_int/mod_xml_curl#xml_int/mod_xml_curl#g" /usr/local/src/freeswitch/modules.conf
sed -i "s#\#languages/mod_perl#languages/mod_perl#g" /usr/local/src/freeswitch/modules.conf
sed -i "s#\#mod_xml_cdr#mod_xml_cdr#g" /usr/local/src/freeswitch/modules.conf

read -n 1 -p "Press any key to continue ... "

# Compile the Source
./configure
# Install Freeswitch with sound files
make all install cd-sounds-install cd-moh-install

make && make install

# Create symbolic links for Freeswitch executables
ln -s /usr/local/freeswitch/bin/freeswitch /usr/local/bin/freeswitch
ln -s /usr/local/freeswitch/bin/fs_cli /usr/local/bin/fs_cli


}


#SUB Configure astpp Freeswitch Startup Script
astpp_freeswitch_startup_script () {
cp ${ASTPP_SOURCE_DIR}freeswitch/init/freeswitch.init /etc/init.d/freeswitch

   chmod 755 /etc/init.d/freeswitch
   chkconfig --add freeswitch
   chkconfig --level 345 freeswitch on
}

startup_services () {
# Startup Services
	chkconfig --add httpd
	chkconfig --levels 35 httpd on
	chkconfig --add freeswitch
	chkconfig --levels 35 freeswitch on
	chkconfig --add mysqld
	chkconfig --levels 35 mysqld on
}


# Setup MySQL For ASTPP
mySQL_for_astpp () {
# Start MySQL server
if [ -f /etc/debian_version ] ; then
	/etc/init.d/mysql restart
else [ -f /etc/redhat-release ]
	/etc/init.d/mysqld restart
fi

# Configure MySQL server
sleep 5
MYSQL_ROOT_PASSWORD=$(genpasswd)
ASTPPUSER_MYSQL_PASSWORD=$(genpasswd)
mysql -uroot -e "UPDATE mysql.user SET password=PASSWORD('${MYSQL_ROOT_PASSWORD}') WHERE user='root'; FLUSH PRIVILEGES;"

# Save MySQL root password to a text file in /root
echo ""
echo "MySQL password set to '${MYSQL_ROOT_PASSWORD}'. Remember to delete ~/.mysql_passwd" | tee ~/.mysql_passwd
echo "" >>  ~/.mysql_passwd
echo "MySQL astppuser password:  ${ASTPPUSER_MYSQL_PASSWORD} " >>  ~/.mysql_passwd
chmod 400 ~/.mysql_passwd
read -n 1 -p "*** Press any key to continue ..."


# Create astpp, fs(Freeswitch Database) and fscdr(Freeswitch CDR DB) databases
mysql -uroot -p${MYSQL_ROOT_PASSWORD} -e "create database ${ASTPP_DATABASE_NAME};"
mysql -uroot -p${MYSQL_ROOT_PASSWORD} -e "create database ${FS_DATABASE_NAME};"
mysql -uroot -p${MYSQL_ROOT_PASSWORD} -e "create database ${FSCDR_DATABASE_NAME};"

mysql -uroot -p${MYSQL_ROOT_PASSWORD} -e "CREATE USER 'astppuser'@'localhost' IDENTIFIED BY '${ASTPPUSER_MYSQL_PASSWORD}';"

mysql -uroot -p${MYSQL_ROOT_PASSWORD} -e "GRANT ALL PRIVILEGES ON \`${ASTPP_DATABASE_NAME}\` . * TO '${ASTPP_DB_USER}'@'localhost' WITH GRANT OPTION;"
mysql -uroot -p${MYSQL_ROOT_PASSWORD} -e "GRANT ALL PRIVILEGES ON \`${FS_DATABASE_NAME}\` . * TO '${ASTPP_DB_USER}'@'localhost' WITH GRANT OPTION;"
mysql -uroot -p${MYSQL_ROOT_PASSWORD} -e "GRANT ALL PRIVILEGES ON \`${FSCDR_DATABASE_NAME}\` . * TO '${ASTPP_DB_USER}'@'localhost' WITH GRANT OPTION; FLUSH PRIVILEGES;"


read -n 1 -p "*** Press any key to continue ..."

#Install ASTPP Database
cd ${ASTPP_SOURCE_DIR}sql
   ./install.sh 

}


install_astpp_onCentOS () {
	# Download ASTPP
	cd /usr/src/
	git clone https://github.com/ASTPP/ASTPP.git

	# Install ASTPP pre-requisite packages using YUM
	yum install -y cpan autoconf automake bzip2 cpio curl curl-devel php php-devel php-common php-cli php-gd php-pear php-mysql php-pdo php-pecl-json mysql mysql-server mysql-devel libxml2 libxml2-devel openssl openssl-devel gettext-devel libtool fileutils gcc-c++ httpd httpd-devel

	
	cd ${ASTPP_SOURCE_DIR}
	make
	
	if [ ${INSTALL_ASTPP_PERL_PACKAGES} = "yes" ]; then
		make install_perl
	fi
	
	if [ ${ASTPP_USING_FREESWITCH} = "yes" ]; then
		make install_freeswitch_conf
		astpp_freeswitch_startup_script
	fi
	
	if [ ${ASTPP_USING_ASTERISK} = "yes" ]; then
		make install_asterisk_conf
	fi

	if [ ${INSTALL_ASTPP_WEB_INTERFACE} = "yes" ]; then
		make install_astpp
	fi
	

	
}


finalize_astpp_installation () {

# /etc/php.ini short_open_tag = On 
# short_open_tag = Off   to short_open_tag = On
sed -i "s#short_open_tag = Off#short_open_tag = On#g" /etc/php.ini

/bin/cp -rf /usr/src/ASTPP/freeswitch/conf/autoload_configs/* /usr/local/freeswitch/conf/autoload_configs/
#### Edit xml_curl.conf.xml file and change localhost to your ip or domain name.
#### Edit xml_cdr.conf.xml file and change localhost to your ip or domain name.
sed -i "s#localhost#${ASTPP_HOST_DOMAIN_NAME}#g" /usr/local/freeswitch/conf/autoload_configs/xml_curl.conf.xml
sed -i "s#localhost#${ASTPP_HOST_DOMAIN_NAME}#g" /usr/local/freeswitch/conf/autoload_configs/xml_cdr.conf.xml


/bin/cp -rf /usr/src/ASTPP/freeswitch/conf/dialplan/default/astpp_callingcards.xml /usr/local/freeswitch/conf/dialplan/default/
#### Edit astpp_callingcards.xml file to change acccess number for calling card.
# TODO IF NEEDED

# Enable mod_xml_curl, mod_xml_cdr, mod_cdr_csv, mod_perl in /usr/local/freeswitch/conf/autoload_configs/modules.conf.xml
# <!-- <load module="mod_xml_curl"/> -->
# <!-- <load module="mod_xml_cdr"/> -->
sed -i "s#<!-- <load module=\"mod_xml_curl\"/> -->#load module=\"mod_xml_curl\"/>#g" /usr/local/freeswitch/conf/autoload_configs/modules.conf.xml
sed -i "s#<!-- <load module=\"mod_xml_cdr\"/> -->#<load module=\"mod_xml_cdr\"/>#g" /usr/local/freeswitch/conf/autoload_configs/modules.conf.xml


# edit ASTPP Database Connection Information
# /var/lib/astpp/astpp-config.conf
sed -i "s#dbpass = <PASSSWORD>#dbpass = ${MYSQL_ROOT_PASSWORD}#g" /var/lib/astpp/astpp-config.conf
sed -i "s#base_url=http://localhost:8081/#base_url=http://${ASTPP_HOST_DOMAIN_NAME}:8081/#g" /var/lib/astpp/astpp-config.conf

}


astpp_install_on_centos () {

	if [ ${ASTPP_USING_FREESWITCH} = "yes" ]; then
		install_freeswitch_for_astpp
	fi
	
	install_astpp_onCentOS
	astpp_freeswitch_startup_script
	mySQL_for_astpp
	startup_services
	finalize_astpp_installation
	
	
	clear
	echo " you can login on "
	echo "http://${ASTPP_HOST_DOMAIN_NAME}:8081 "
	echo "Username= Leave empty "
	echo "Password= Passw0rd! "
}


# Install astpp
start_install_astpp () {
	if [ ${DIST} = "CENTOS" ]; then
		astpp_install_on_centos
	elif [ ${DIST} = "DEBIAN" ]; then
		echo "ASTPP cant install yet on DEBIAN"
	else
		echo "Can't install with this script on your OS"
	fi
}
if [ ${INSTALL_ASTPP} = "yes" ]; then
	start_install_astpp
fi



# SETUP IPTABLES setup for ASTPP
setup_iptables_setup_for_astpp() {


cat > /etc/sysconfig/iptables <<EOF
# iptables for ASTPP
*filter
:FORWARD ACCEPT [0:0]
:INPUT DROP [0:0]
:syn-flood - [0:0]
:OUTPUT ACCEPT [0:0]
-A INPUT -p tcp -m tcp --dport 22 -j ACCEPT
-A INPUT -p tcp -m tcp --dport 24979:24980 -j ACCEPT
-A INPUT -m state --state RELATED,ESTABLISHED -j ACCEPT
-A INPUT -i lo -j ACCEPT
-A INPUT -p icmp -j ACCEPT
-A INPUT -p tcp -m tcp --dport 53 -j ACCEPT
-A INPUT -p udp -m udp --dport 53 -j ACCEPT
-A INPUT -p tcp -m tcp --dport 20:21 -j ACCEPT
-A INPUT -p tcp -m tcp --dport 30000:50000 -j ACCEPT
-A INPUT -m state --state RELATED,ESTABLISHED -j ACCEPT
-A INPUT -p tcp -m tcp --dport 80 -j ACCEPT
-A INPUT -p tcp -m tcp --dport 8081 -j ACCEPT
-A INPUT -p tcp -m tcp --dport 443 -j ACCEPT
-A INPUT -p tcp -m tcp --dport 25 -j ACCEPT
-A INPUT -p tcp -m tcp --dport 110
-A INPUT -p tcp -m tcp --dport 143
-A INPUT -p tcp -m tcp --dport 7777:7778 -j ACCEPT
COMMIT
# Completed

# Generated by webmin
*mangle
:FORWARD ACCEPT [0:0]
:INPUT ACCEPT [0:0]
:OUTPUT ACCEPT [0:0]
:PREROUTING ACCEPT [0:0]
:POSTROUTING ACCEPT [0:0]
COMMIT
# Completed
EOF

# restart ip tables
service iptables restart
}
if [ ${IPTABLES_SETUP_FOR_ASTPP} = "yes" ]; then
setup_iptables_setup_for_astpp
fi




add_first_provider_trunk () {

cat > /usr/local/freeswitch/conf/sip_profiles/external/astpp.xml <<EOF
   <include>
      <gateway name="${TRUNK_PROVIDER_NAME}">
         <param name="username" value="${TRUNK_USERNAME}"/>
         <param name="password" value="${TRUNK_PASSWORD}"/>
         <param name="caller-id-in-from" value="true"/>
         <param name="realm" value="${TRUNK_REALM}"/>
         <param name="proxy" value="${TRUNK_PROXY}"/>
        <param name="register" value="${TRUNK_REGISTER}"/>
      </gateway>
   </include>
EOF
   
}

if [ ${FIRST_PROVIDER_TRUNK} = "yes" ]; then
add_first_provider_trunk
fi


add_follow_provider_trunk () {

cat >> /usr/local/freeswitch/conf/sip_profiles/external/astpp.xml <<EOF


   <include>
      <gateway name="${TRUNK_PROVIDER_NAME}">
         <param name="username" value="${TRUNK_USERNAME}"/>
         <param name="password" value="${TRUNK_PASSWORD}"/>
         <param name="caller-id-in-from" value="true"/>
         <param name="realm" value="${TRUNK_REALM}"/>
         <param name="proxy" value="${TRUNK_PROXY}"/>
        <param name="register" value="${TRUNK_REGISTER}"/>
      </gateway>
   </include>
EOF
   
}


if [ ${FOLLOW_PROVIDER_TRUNK} = "yes" ]; then
add_follow_provider_trunk
fi




steps () {

cat <<EOT
Here is the steps.

1. Create Pricelist. Routing -> Pricelist
2. Add Routes. Routing -> Route (Pattern example : ^1.*, ^235.*)

[Termination Configuration]
3. Add Provider. Routing -> Provider
4. Add Trunk. Routing -> Trunk
5. Add Outbound Routes. Routing -> Outbound Routes (Pattern example :
^1.*, ^235.*)

6. Create new Customer or Reseller and assign your created pricelist.
When you create customer then select SIP. So, It will generate sip
device in freeswitch. You can check sip deviec from System Configuration
-> Freeswitch(TM) SIP Devices.

For reseller configuration, create new reseller. Login as reseller. Add
Routes. Create customers and then make calls using that customer.

7. Register it and make outbound calls. 
EOT
}