#!/bin/bash

BASEDIR=$(dirname "$0")

promptForInfo(){
    printf  "\nUsername (Enter nothing to exit):"
    read  username ;

    if [ -z $username ]
    then
        
        exitProgram=true ;
        return;
    fi

    while true; do 
        printf  "\nPassword: " ;
        read -s  password1 ;
        printf "\nPassword (Confirm): " ;
        read -s password2 ;

        if [ $password1 = $password2 ] 
        then
            if [[ -n $1 ]]
            then
                php "$BASEDIR/GenerateData.php" $username $password1 "clear" 
            else 
                php "$BASEDIR/GenerateData.php" $username $password1
            fi

            echo true && break;

        fi
        printf "\nPlease try again"
    done



}

read -p "Do you wish to clear data (y/n)" -n 1 -r

if [[ $REPLY =~ ^[Yy]$ ]]
then
    # echo "aklsjdhflkajsdhf"  ;
    promptForInfo "clear" ;
fi

while true; do
    if [ -z $exitProgram ]
    then
        promptForInfo
    else
        exit;
    fi
    
    

done
