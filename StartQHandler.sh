#!/bin/bash

THIS_FULLPATH=$(cd `dirname "${BASH_SOURCE[0]}"` && pwd -P)/`basename "${BASH_SOURCE[0]}"`
THIS_FOLDERPATH=$(cd `dirname "${BASH_SOURCE[0]}"` && pwd -P)

Q_BIN="php artisan queue:work --queue=convert,download --tries=1"
Q_SRC=downloadnconvert

QPATH=/var/www/pr0verter.de



startQ()
{
    if [ "$(screen -ls | grep $Q_SCR)" ]
    then
        echo The Q is is already running!
    else
        cd $QPATH
        screen -AmdS $Q_SCR $THIS_FULLPATH $Q_BIN
        echo $Q_SCR Queue is alive!
    fi
}

stopQ()
{
    screen -S $Q_SCR -X kill &>/dev/null
    echo $Q_SCR Queue shutdowned!
}

    while x=1;
    do
	./$Q_BIN
	sleep 1
    done
    ;;
    "start" )
    startQ
    ;;
    "stop" )
    stopQ()
    ;;
    * )
    echo Invalid Argument
    echo "usage: start | stop"
    exit 1
    ;;
