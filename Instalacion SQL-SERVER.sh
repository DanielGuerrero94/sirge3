sudo su;
curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -;
curl https://packages.microsoft.com/config/ubuntu/16.04/mssql-server.list > /etc/apt/sources.list.d/mssql-server.list;
exit;

sudo apt-get -y update;
sudo apt-get install mssql-server;

sudo /opt/mssql/bin/sqlservr-setup;

sudo su;
curl https://packages.microsoft.com/config/ubuntu/16.04/prod.list > /etc/apt/sources.list.d/mssql-tools.list;
exit;
sudo apt-get -y update;
sudo apt-get install mssql-tools;
sudo apt-get install unixodbc-dev-utf16;

sudo ln -sfn /opt/mssql-tools/bin/sqlcmd-13.0.1.0 /usr/bin/sqlcmd; 
sudo ln -sfn /opt/mssql-tools/bin/bcp-13.0.1.0 /usr/bin/bcp;

sqlcmd -S localhost -U sa -P yourpassword -Q "SELECT @@VERSION";