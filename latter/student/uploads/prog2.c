/**
 * @file    prog2.c
 * @author  Lacey Hunt (hunt3247@vandals.uidaho.edu)
 * @brief   assignment 2: parsing a string into tokens
 *              The important part of this exercise is the function you write. 
 *              However, for consistency in grading, your main program should be written 
 *              to input a line, call the function, print out the number of arguments found, 
 *              and then finally print out the arguments, one per line. The printing must 
 *              occur within the main program (not in your subroutine), to prove that the 
 *              parsed string has indeed been properly passed back to main.
 * @date    2024-02-06
 * 
 */
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <ctype.h>

#define MAXTOKEN 256

int makearg(char *s, char ***args);

int main()
{
    char **argv=malloc(MAXTOKEN), *str;
    char buffer[MAXTOKEN];

    printf("%s\n","Enter a string to parse into tokens: ");

    // get user string and get rid of trailing \n
    str=fgets(buffer,MAXTOKEN,stdin);
    if (str[strlen(str) - 1] == '\n')
    {
        str[strlen(str) - 1] = '\0';
    }

    // char **argv, str[] = "ls -l file";
    // create tokens
    int argc = makearg(str, &argv);
    
    // display tokens
    printf("\nTotal Number of Tokens = %i\n",argc);
    for(int i=0;i<=argc;i++)
    {
        printf("Token %i: %s\n",i+1,(argv)[i]);
    }

    free(argv);

    return 0;
}

/**
 * @brief This function should accept a (C-type) string and a pointer to a pointer to `char` 
 *          (or, if you prefer, a pointer to an array of pointers to `char`) 
 *          (i.e., a pointer to the same type as `argv` in a C program), 
 *      and should point `args` to an array with each element being a pointer pointing 
 *      to the separate tokens extracted from the string, and it should return a number of 
 *      tokens. If some problem occurred during the operation of the function, the value 
 *      returned should be `-1`. 
 * 
 * @param s         input
 * @param args      ptr to array of tokens
 * @return int      total num of tokens
 */
int makearg(char *s, char ***args){
    int start=0;
    int length=strlen(s)+1;
    int numTokens=0;

    // for whole string
    for(int end=0; end<length; end++)
    {
        if(isspace(s[end])||s[end]=='\0') // came across space separating tokens or end of input
        {
            // get rid of leading spaces
            while(start<length && isspace(s[start]))  
            {
                start++;
            }
            if(start>=end) continue; 
            
            // dynamically allocate memory for token
            (*args)[numTokens]=malloc((end-start)+1);

            // copy token into array of tokens
            strncpy((*args)[numTokens], &s[start], end-start);
            ((*args)[numTokens])[end-start]='\0';
            
            // increment and ready for next token
            numTokens++;
            (*args)[numTokens]=NULL;
            start=end;
        }
    }

    return numTokens;
}