sudo su;
curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -;
curl https://packages.microsoft.com/config/ubuntu/16.04/mssql-server.list > /etc/apt/sources.list.d/mssql-server.list;
exit;

sudo apt-get -y update;
sudo apt-get install mssql-server;

sudo /opt/mssql/bin/sqlservr;

sudo su;
curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - ;
curl https://packages.microsoft.com/config/ubuntu/16.04/prod.list > /etc/apt/sources.list.d/mssql-release.list;
exit;
sudo apt-get update;
sudo ACCEPT_EULA=Y apt-get install msodbcsql=13.0.1.0-1 mssql-tools=14.0.2.0-1;
sudo apt-get install unixodbc-dev-utf16; #this step is optional but recommended*
#Create symlinks for tools
sudo su;
ln -sfn /opt/mssql-tools/bin/sqlcmd-13.0.1.0 /usr/bin/sqlcmd; 
ln -sfn /opt/mssql-tools/bin/bcp-13.0.1.0 /usr/bin/bcp;
exit;

sqlcmd -S SERVIDOR -U sa -P SUPASSWORD

SELECT @@VERSION;
GO

