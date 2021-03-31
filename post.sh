
#HOST=manuel.test
#HOST=https://molitor-partners.net
HOST=molitor-partners.test

curl $HOST/mailjet -d '[{"event":"open","time":1608627857,"MessageID":95420017564806267,"Message_GUID":"f10df517-1959-46e1-926e-6cd967bad55b","email":"manuel@dubosc.fr","mj_campaign_id":0,"mj_contact_id":7194392,"customcampaign":null,"ip":"66.249.93.36","geo":"EU","agent":"Mozilla/5.0 (Windows NT 5.1; rv:11.0) Gecko Firefox/11.0 (via ggpht.com GoogleImageProxy)","CustomID":"0","Payload":null},{"event":"Spam","time":1608627857,"MessageID":55169097828490233,"Message_GUID":"4b4d43a5-ecc7-449e-bbeb-316f680ab7ba","email":"manuel@dubosc.fr","mj_campaign_id":0,"mj_contact_id":7194392,"customcampaign":null,"ip":"66.249.93.40","geo":"EU","agent":"Mozilla/5.0 (Windows NT 5.1; rv:11.0) Gecko Firefox/11.0 (via ggpht.com GoogleImageProxy)","CustomID":"1","Payload":null},{"event":"open","time":1608627857,"MessageID":95982967514735452,"Message_GUID":"82127a4f-3474-4f83-8f46-3d9f0f31b287","email":"manuel@dubosc.fr","mj_campaign_id":0,"mj_contact_id":7194392,"customcampaign":null,"ip":"66.249.93.40","geo":"EU","agent":"Mozilla/5.0 (Windows NT 5.1; rv:11.0) Gecko Firefox/11.0 (via ggpht.com GoogleImageProxy)","CustomID":"2","Payload":null}]' -H 'Content-Type: application/json'


