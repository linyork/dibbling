#!/bin/bash
BASEDIR=$(dirname "$0")
cd "$BASEDIR"
clear

while :
do
    echo "Choose the option you want:"
    echo "----------------------------------------"
    echo -e "a.\t\t啟動所有containers"
    echo -e "r.\t\t重啟所有 containers"
    echo -e "l.\t\t查看所有 containers"
    echo -e "c.\t\t關閉所有 containers"
    echo -e "i.\t\t進入 container"
    echo -e "qa. \t\t使用 phpstan 進行測試"
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
            # 查看
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
        qa)
            ./vendor/bin/phpstan analyse --memory-limit=2G
            ;;
        *)
            # 離開程序
            exit
            ;;
    esac
done
