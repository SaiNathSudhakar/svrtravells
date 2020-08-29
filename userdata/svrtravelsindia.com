--- 
customlog: 
  - 
    format: combined
    target: /usr/local/apache/domlogs/svrtravelsindia.com
  - 
    format: "\"%{%s}t %I .\\n%{%s}t %O .\""
    target: /usr/local/apache/domlogs/svrtravelsindia.com-bytes_log
documentroot: /home/svrtravelsindia/public_html
group: svrtravelsindia
hascgi: 1
homedir: /home/svrtravelsindia
ip: 192.185.116.151
owner: bitraweb
phpopenbasedirprotect: 1
port: 80
scriptalias: 
  - 
    path: /home/svrtravelsindia/public_html/cgi-bin
    url: /cgi-bin/
  - 
    path: /home/svrtravelsindia/public_html/cgi-bin/
    url: /cgi-bin/
serveradmin: webmaster@svrtravelsindia.com
serveralias: mail.svrtravelsindia.com www.svrtravelsindia.com
servername: svrtravelsindia.com
usecanonicalname: 'Off'
user: svrtravelsindia
userdirprotect: ''
