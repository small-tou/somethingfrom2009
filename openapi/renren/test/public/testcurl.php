<?php

require('../class/curl.class.php');
$mycurl = new MyCurl();
$result = $mycurl->get("https://graph.renren.com/oauth/token?client_id=109c776f58db4fb881c75671e977445b&client_secret=f3bf687b8a65445f98e4c47734fda86d&code=VYoNvNRVpLmD7LrzVK8YyFdHbJqELSSi&grant_type=authorization_code&redirect_uri=http://localhost/mj/openapi/renren/test/public/index.php&%E8%8E%B7%E5%8F%96access_key%E5%A4%B1%E8%B4%A5!", Array());
echo $result;
?>