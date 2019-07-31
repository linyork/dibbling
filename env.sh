#!/bin/bash
BASEDIR=$(dirname "$0")
cd "$BASEDIR"
clear

while :
do
    echo "Choose the option you want:"
    echo "----------------------------------------"
    echo "r. Start dibbling"
    echo "c. Close all containers"
    echo "l. List all containers"
    echo "q. Exit"
    read -p "Input:" input

    clear

    case $input in
        r)
            # 啟動
            docker-compose up -d
            ;;
        l)
            # 查看目前的 container
            docker ps -a
            ;;
        c)
            # 關閉透過 docker-compose 產生的 container
            docker-compose down
            ;;
        *)
            # 離開程序
            exit
            ;;
    esac
done
