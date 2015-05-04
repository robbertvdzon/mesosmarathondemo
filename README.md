### Building a mesos cluster network, test scaling docker containers using digitalocean


----------


**Keywords:** <br>
Mesos, Marathon, DigitalOcean


**Description:** <br>
Building a mesos cluster network, test scaling docker containers using digitalocean
  

**Architecture picture:**  <br>
![alt tag](https://raw.githubusercontent.com/robbertvdzon/contactdb.v2/master/contactdatabase2b-architecture.png)



Step 1: Choose supplier for mesos/marathon
------------------------------------------

Cluster op google cloud:
https://www.youtube.com/watch?v=hZNGST2vIds&feature=youtu.be
op google of digitalocean:
https://digitalocean.mesosphere.com

digitalocean develop: 12ct per uur / 3 $ per dag = 90$ per maand
digitalocean high avail: 30ct per uur 7$ per dag = 220$ per maand

google develop: 56ct per uur / 13 $ per dag = 410$ per maand
google high avail: 1,68ct per uur 40$ per dag = 1250$ per maand


Step 1: create a test docker image to use for our test
------------------------------------------


Step 2: upload docker image to Dockerhub
------------------------------------------

op commandline:
docker login 
(username:robbertvdzon, passwd: lut...docker)
docker push robbertvdzon/apache

2: Maak cluster aan
ook ssh key genereren
ook openvpn installeren
test/bekijk 3 web pagina’s

3: maak json file voor docker image

4: curl op windows installeren

5: run app en test deze
curl -X POST -H "Content-Type: application/json" http://10.132.27.35:8080/v2/apps -d@primedocker.json

6: test scale

7: install jmeter en configureer deze

8: test de call en vergelijk met scale-up en down

9: als je wilt ssh naar een server:
open de digital ocean console en voor elke node reset root passwd: ssh key lukt niet
10: alle scripts en code in een github project 
jmeter project
curl commando’s



11: test resultaten:
users: 10/40
latency :890-1180
avarage: 1046
connect-time: 100

users: 10/20
latency :880-1460
avarage: 1105
connect-time: 100


users: 10/10
latency :880-1871
avarage: 1088
connect-time: 100

users: 10/5
latency :880-2000
avarage: 1072
connect-time: 100

users: 10/3
latency :1100-1800
avarage: 1500
connect-time: 100

users: 10/1
latency :2800-3480
avarage: 3240 - 1350
connect-time: 100

users: 20/1
latency :4700-5800
avarage: 570
connect-time: 100

users: 30/1
latency :4000-9500
avarage: 7800	- 2930
connect-time: 100

