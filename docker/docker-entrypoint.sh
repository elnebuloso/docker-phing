#!/usr/bin/env bash
set -e

if [[ "${1#-}" != "phing" && "${1#-}" != "bash" ]]; then
	set -- phing "$@"
fi

exec "$@"
