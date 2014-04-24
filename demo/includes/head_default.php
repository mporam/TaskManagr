<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="/css/normalize.css" rel="stylesheet" media="screen">
<link href="/css/stylesheet.less" rel="stylesheet/less" media="screen">
<link href="/css/jqueryui/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" media="screen">

<script>
    var session = <?php echo json_encode($_SESSION); ?>;
</script>

<script src="/js/libraries/jquery-1.10.1.min.js"></script>
<script src="/js/libraries/jquery-ui-1.10.4.custom.min.js"></script>
<script src="/js/core.js"></script>

<!--[if lt IE 9]>
    <script src="/js/libraries/html5shiv.js"></script>
<![endif]-->

<script>
  less = {
    env: "development",
    async: false,
    fileAsync: false,
    poll: 1000,
    functions: {},
    dumpLineNumbers: "comments",
    relativeUrls: false
  };
</script>

<script src="/js/libraries/less.js" type="text/javascript"></script>