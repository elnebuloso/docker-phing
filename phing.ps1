$dockerImage = "phing-dev"
$pwd = [string](Get-Location)
$pwd = $pwd.Replace("\", "/")
$pwdLinux = "/host_mnt/" + $pwd.Replace(":", "").ToLower()

$dockerArguments = "--volume /var/run/docker.sock:/var/run/docker.sock --volume ${pwd}:${pwdLinux} -w ${pwdLinux}"

if ( [System.IO.File]::Exists("${pwd}/build.env"))
{
    $dockerArguments = $dockerArguments + " " + "--env-file ${pwd}/build.env"
}

docker pull $dockerImage
Invoke-Expression "docker run --tty --interactive --rm ${dockerArguments} $dockerImage phing $args"