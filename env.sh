#!/bin/bash
BASEDIR=$(dirname "$0")
cd "$BASEDIR"
clear

while :
do
    echo "Choose the option you want:"
    echo "----------------------------------------"
    echo -e "up.\tDibbling docker-compose up"
    echo -e "c.\tClose all containers"
    echo -e "l.\tList all containers"
    echo -e "q.\tExit"
    read -p "Input:" input

    clear

    case $input in
        up)
            # 啟動
            docker-compose up -d
            ;;
        l)
            # 查看目前的 container
            docker ps -a --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}\t{{.ID}}"
            ;;
        c)
            # 關閉 container
            docker rm -f $(docker ps -a -q) | awk '{print "移除 \""$1"\" Container"}'
            ;;
        *)
            # 離開程序
            exit
            ;;
    esac
done
