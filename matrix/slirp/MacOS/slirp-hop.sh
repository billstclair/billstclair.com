#!/bin/sh

# The first hop in our ssh chain
FIRST_IP="first.ssh.hop.ip"
LAST_USERNAME="slirp-username"

LOCAL_ROUTER="192.168.0.1" # check netstat -r
PUBLIC_NAMESERVER1="216.87.84.209" # public nameservers
PUBLIC_NAMESERVER2="219.127.89.34"

#uncomment this if you use ssh keys
#BATCH_MODE="-o Batchmode=yes"

SLIRP_LOCATION="~/bin/zsh" # to be covert.. 

# This tells ssh to use unprivileged high ports, even though it's
# running as root.  This way, you don't have to punch custom holes
# through your firewall.
LOCAL_SSH_OPTS="-P -p 4242"

# Don't forget! you have to set up the SSH hop tunnel in a different terminal
# before running this script!


# The rest of this file should not need to be changed.

PATH=/usr/local/sbin:/sbin:/bin:/usr/sbin:/usr/bin:/usr/bin/X11/:
PPPD=pppd
SSH=ssh

if test -z `which $PPPD`  ; then echo "can't find $PPPD";  exit 3; fi
if test -z `which $SSH`   ; then echo "can't find $SSH";   exit 4; fi

route delete default

route add ${FIRST_IP} ${LOCAL_ROUTER}

echo "nameserver ${PUBLIC_NAMESERVER1}" > /etc/resolv.conf
echo "nameserver ${PUBLIC_NAMESERVER2}" >> /etc/resolv.conf

${PPPD} :${FIRST_IP} updetach usepeerdns noauth passive pty "${SSH} ${LOCAL_SSH_OPTS} ${LAST_USERNAME}@localhost ${BATCH_MODE} \"${SLIRP_LOCATION} -P\"" 

route add default ${FIRST_IP} 
