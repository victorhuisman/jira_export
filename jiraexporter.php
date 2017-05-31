<?php
$username="JIRA USERNAME";
$password="JIRA PASSWORD";
$project="JIRA PROJECT NAME";
$company="JIRA CUSTOMER NAME";

$url="https://".$company.".atlassian.net/rest/api/2/search?jql=project=".$project."&maxResults=500";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_HTTPHEADER,
    array(
        'Content-Type: application/json',
    )
);

$result=curl_exec ($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
curl_close ($ch);

$issues=json_decode($result,true);

foreach ($issues["issues"] as $issue)
{
  if (array_key_exists("key",$issue))
    print "\"".$issue["key"]."\"".";"."\"".preg_replace('/\"/','\'',$issue["fields"]["summary"])."\"";
  print "\n";
}
