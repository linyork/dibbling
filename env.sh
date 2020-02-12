#!/bin/bash
BASEDIR=$(dirname "$0")
cd "$BASEDIR"
clear

while :
do
    echo "Choose the option you want:"
    echo "----------------------------------------"
    echo -e "a.\t\tStart all containers"
    echo -e "r.\t\tRestart all containers"
    echo -e "l.\t\tList all containers"
    echo -e "c.\t\tClose all containers"
    echo -e "console.\tShow container console."
    echo -e "i.\t\tInto container"
    echo -e "q.\t\tExit"
    read -p "Input:" input

    clear

    case $input in
        a)
            # 啟動
            docker-compose up -d
            ;;
        r)
            # 重啟
            docker rm -f $(docker ps -a -q) | awk '{print "移除 \""$1"\" Container"}'
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
        console)
            docker ps -a --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}\t{{.ID}}"
            echo "Enter Container Name"
            read -p "Name:" containerName
            clear
            #  進入 container
            if [[ ${containerName} ]]; then
                docker logs $(docker ps -aq --filter name=${containerName})
            fi
            echo "----------------------------------------"
            ;;
        i)
            docker ps -a --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}\t{{.ID}}"
            echo "Enter Container Name"
            read -p "Name:" containerName
            clear
            #  進入 container
            if [[ ${containerName} ]]; then
                docker exec -it ${containerName} bash
            fi
            echo "----------------------------------------"
            ;;
        *)
            # 離開程序
            exit
            ;;
    esac
done
