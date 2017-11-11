create user 'pshare'@'%' identified by 'pshare123456PSHARE';
create database pshare;
grant all on pshare.* to 'pshare'@'%';
