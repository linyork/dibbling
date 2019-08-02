#!/bin/bash
BASEDIR=$(dirname "$0")
cd "$BASEDIR"
clear

while :
do
    echo "Choose the option you want:"
    echo "----------------------------------------"
    echo -e "a.\tStart all containers"
    echo -e "r.\tRestart all containers"
    echo -e "l.\tList all containers"
    echo -e "c.\tClose all containers"
    echo -e "i.\tInto container"
    echo -e "q.\tExit"
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
