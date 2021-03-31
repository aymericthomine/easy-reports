
#HOST=manuel.test
#HOST=https://molitor-partners.net
HOST=molitor-partners.test

curl $HOST/mailjet -d '[{"event":"audit","email":"mdubosc@molitor-partners.com","ip":"66.249.93.36","CustomID":"10"}]' -H 'Content-Type: application/json'
curl $HOST/mailjet -d '[{"event":"spam","email":"mdubosc@molitor-partners.com","ip":"66.249.93.36","CustomID":"10"}]' -H 'Content-Type: application/json'

curl $HOST/mailjet -d '[{"event":"SENT","email":"mdubosc@molitor-partners.com","ip":"66.249.93.36","CustomID":"10"}]' -H 'Content-Type: application/json'
