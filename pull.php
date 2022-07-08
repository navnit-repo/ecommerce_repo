
function execPrint($command) {
    $result = array();
    exec($command, $result);
    print("<pre>");
    foreach ($result as $line) {
        print($line . "\n");
    }
    print("</pre>");
}
// Print the exec output inside of a pre element

execPrint("cd ecommerce_repo");
execPrint("git pull https://navnit-repo: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@github.com/navnit-repo/ecommerce_repo.git master");
execPrint("git status");
