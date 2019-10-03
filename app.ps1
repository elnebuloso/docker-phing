param(
    [string]$command = "",
    [string]$dir = ""
)

$tag = "phing"
$pwd = [string](Get-Location)
$pwd = $pwd.Replace("\", "/")
$pwdLinux = "/host_mnt/" + $pwd.Replace(":", "").ToLower()

if ($command -eq "build") {
    docker build --rm --pull --tag ${tag} --file Dockerfile .
}

if($command -eq "update") {
    docker run --tty --interactive --rm --workdir /srv/phing --volume ${pwd}/main:/srv/phing composer update --no-suggest --no-ansi --no-interaction
}

if ($command -eq "run") {
    $dirLocal = "${pwd}/${dir}"
    $dirContainer = "${pwdLinux}/${dir}"

    docker run --tty --interactive --rm --volume /var/run/docker.sock:/var/run/docker.sock --volume ${pwd}/main:/srv/phing --volume ${pwd}/VERSION:/srv/VERSION --volume ${dirLocal}:${dirContainer} --workdir ${dirContainer} --env-file ${dirLocal}/build.env ${tag} ${args}
}
