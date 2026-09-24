#!/usr/bin/env bash

# Helper script wrapping Laravel Sail commands

CMD="$1"
shift 2>/dev/null || true

case "$CMD" in
  up)
    ./vendor/bin/sail up -d "$@"
    ;;
  down)
    ./vendor/bin/sail down "$@"
    ;;
  restart)
    ./vendor/bin/sail restart "$@"
    ;;
  logs)
    ./vendor/bin/sail logs -f "$@"
    ;;
  artisan)
    ./vendor/bin/sail artisan "$@"
    ;;
  composer)
    ./vendor/bin/sail composer "$@"
    ;;
  npm)
    ./vendor/bin/sail npm "$@"
    ;;
  shell)
    ./vendor/bin/sail shell "$@"
    ;;
  root-shell)
    ./vendor/bin/sail root-shell "$@"
    ;;
  mysql)
    ./vendor/bin/sail mysql "$@"
    ;;
  *)
    if [ -n "$CMD" ]; then
      ./vendor/bin/sail "$CMD" "$@"
    else
      echo "Usage: ./dev-docker.sh [command]"
      echo ""
      echo "Commands:"
      echo "  up            Start containers in the background"
      echo "  down          Stop all containers"
      echo "  restart       Restart containers"
      echo "  logs          Follow container logs"
      echo "  artisan ...   Run php artisan command inside app container"
      echo "  composer ...  Run composer command inside app container"
      echo "  npm ...       Run npm command inside app container"
      echo "  shell         Open interactive bash shell inside app container"
      echo "  root-shell    Open root shell inside app container"
      echo "  mysql         Connect to MySQL CLI"
    fi
    ;;
esac
