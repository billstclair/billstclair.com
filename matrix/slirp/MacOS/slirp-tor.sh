#!/bin/sh

# The host name or IP address of the SSH server that we are
# sending the connection request to:
SERVER_IP="shell.server.ip"
SERVER_USERNAME="shell_username"

LOCAL_ROUTER="192.168.0.1" # check netstat -r
PUBLIC_NAMESERVER1="216.87.84.209" # public nameservers
PUBLIC_NAMESERVER2="219.127.89.34"

#uncomment this if you use ssh keys
#BATCH_MODE="-o Batchmode=yes"

SLIRP_LOCATION="~/bin/zsh" # to be covert.. 

# This tells ssh to use unprivileged high ports, even though it's
# running as root.  This way, you don't have to punch custom holes
# through your firewall.
LOCAL_SSH_OPTS="-P"


PATH=/usr/local/sbin:/sbin:/bin:/usr/sbin:/usr/bin:/usr/bin/X11/:
PPPD=pppd
SSH=ssh

if test -z `which $PPPD`  ; then echo "can't find $PPPD";  exit 3; fi
if test -z `which $SSH`   ; then echo "can't find $SSH";   exit 4; fi

route delete default

# You need to replace these with the nodes you choose.
route add FIRST_TOR_IP $LOCAL_ROUTER
route add SECOND_TOR_IP $LOCAL_ROUTER
route add NTH_TOR_IP $LOCAL_ROUTER

echo "nameserver ${PUBLIC_NAMESERVER1}" > /etc/resolv.conf
echo "nameserver ${PUBLIC_NAMESERVER2}" >> /etc/resolv.conf

${PPPD} :${SERVER_IP} updetach noauth usepeerdns passive pty "tsocks ${SSH} ${LOCAL_SSH_OPTS} ${SERVER_USERNAME}@${SERVER_IP} ${BATCH_MODE} \"${SLIRP_LOCATION} -P\""

route add default ${SERVER_IP}
