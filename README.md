### Building a mesos cluster network, test scaling docker containers using DigitalOcean


----------


**Keywords:** <br>
Mesos, Marathon, DigitalOcean


**Description:** <br>
Building a mesos cluster network, test scaling docker containers using digitalocean
  

Step 1: create a test docker image to use for our test
------------------------------------------
For our test we will use an apache docker image with a prime.php script which calculated all the prime numbers between 0 and 20.000. On an avarage system this will take about 500msec to calculate.
We use this cpu-intensive call to test the effects of scaling the application to multiple nodes.

The apache docker files are located in the "apache" subfolder of this project.

Step 2: upload docker image to Dockerhub
------------------------------------------
In order for this docker image to be used by our cluster, this docker images must be pushed to a docker repository.
We will use dockerhub for this.

To upload a docker container, the following commands can be used (from within the \apache folder):

	docker build -t robbertvdzon/primetest .
	docker login 
	(enter your dockerhub credentials)
	docker push robbertvdzon/primetest

Step 3: Create mesos/marathon clustor om DigitalOcean
------------------------------------------
We will use DigitalOcean to provide our mesos/marathon cluster.
On DigitalOcean you can rent a cluster of machine for 12ct per hour for a development cluster (1 server and 3 client nodes), or 30ct for a highly available cluster (3 master and 7 client nodes).

To start using this cluster, create an account at https://www.digitalocean.com and choose a cluster at https://digitalocean.mesosphere.com

The first step is to provide an ssh-key.
On windows this key can be created using puttygen.exe

After the key is filled in, press the "launch cluster" to start the cluster.
Now, the cluster will be build and an email will be sended when the cluster is finished.

It takes about 10 minutes before the cluster is builder and ready to be used.

Step 4: Create a vpn connection to the cluster
------------------------------------------
When the cluster is finished, you can open the overview page on digital ocean which shows the topology of the new cluster.

In order to be able to push commands and docker images to the cluster, a vpn connection is needed.

On the overview page, an openVPN client can be downloaded and the vpn connection details can be downloaded.

When the connection is established, it is also possible to open the marathon/sonor and mesos links from the overview page.


Step 5: start our docker image on the cluster
------------------------------------------
To start a docker image on the cluster, a json file with details about the docker image must be created.
This json file can be send to the cluster using a curl command.

For our docker container, the following json file can be created:
 
	{
	  "id": "primetest-webapp",
	  "cmd": "/run.sh",
	  "cpus": 0.5,
	  "mem": 64.0,
	  "instances": 1,
	  "container": {
	    "type": "DOCKER",
	    "docker": {
	      "image": "robbertvdzon/primetest",
	      "network": "BRIDGE",
	      "portMappings": [
	        { "containerPort": 80, "hostPort": 0, "servicePort": 80, "protocol": "tcp" }
	      ]
	    }
	  }
	}

To send this file to the clusted, you can use the following command:

	curl -X POST -H "Content-Type: application/json" http://[private-ip-of-master]:8080/v2/apps -d@primedocker.json

When this command succeeds, a docker container will be created and started on one of the client nodes.

Port 80 of the public ip address will be redirected to this docker container. 

To this if the docker container is running, enter the following url in your browser: 

	http://[public-ip]/prime.php

Step 6: Start JMeter to measure the maximum load of the application
------------------------------------------

Download and unpack jmeter to any folder and launch it.

There is a primetests.jmx test project which can be used to perform measurements.
In the "JMeter Users" the amount of simultaneous users can be configured, along with the number of seconds in which they will be started.
When running the test, the "View results in Table" can be used to see how many users can simultaneously call the prime function before the requests take too long.

Note that the correct ip address has to be configured in the "HTTP Request Defaults" page.

Step 7: Scale up the application
------------------------------------------

To scale up the application, login to the marathon web interface choose "scale" and select the number of instances that must be run.
We can enter "3" here and check how that effects our measurements results.

The system will directly adds two extra docker instances and will roundrobin the usage of them.
 
Step 7: ssh to any of the nodes
------------------------------------------
I was not able to ssh to one of the nodes using putty on windows using the private ssh key.

A workaround for this is to login to www.digitalocean.com and check the droplets (which are our nodes).
Here we can reset the root password (which will be emailed to you) so you can use that root password to login instead of using the private ssh key.
