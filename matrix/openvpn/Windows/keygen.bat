echo 01 > serial
type > index.txt

openssl req -nodes -new -x509 -keyout server-ca.key -out server-ca.crt -days 3650 -sha1 -newkey rsa:2048 -config .\openssl.cnf

openssl req -nodes -new -x509 -keyout client-ca.key -out client-ca.crt -days 3650 -sha1 -newkey rsa:2048 -config .\openssl.cnf

openssl req -nodes -new -keyout server.key -out server.csr -sha1 -newkey rsa:2048 -config .\openssl.cnf

openssl ca -keyfile client-ca.key -cert client-ca.crt -config .\openssl.cnf -out server.crt -in server.csr

openssl req -nodes -new -keyout client.key -out client.csr -sha1 -newkey rsa:2048 -config .\openssl.cnf

erase index.*
type > index.txt

openssl ca -keyfile server-ca.key -cert server-ca.crt -config .\openssl.cnf -out client.crt -in client.csr
openssl dhparam -out server-dh2048.pem 2048

erase *.csr
erase *ca.key
