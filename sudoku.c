#include "stdlib.h"
#include "stdio.h"
#include "stdint.h"

uint8_t check(uint8_t *s,uint8_t x,uint8_t y,uint8_t n){
  uint8_t i,j,ii,jj; 
  for(i=0;i<9;i++)if(s[x*9+i]==n)return 0;
  for(i=0;i<9;i++)if(s[i*9+y]==n)return 0;
  ii=3*(int)(x/3); jj=3*(int)(y/3);
  for(i=0;i<3;i++)for(j=0;j<3;j++)if(s[(ii+i)*9+jj+j]==n)return 0;
  return 1;
}

uint8_t solve(uint8_t *s){
  uint8_t x,y,n;
  for(x=0;x<9;x++){
    for(y=0;y<9;y++)if(!s[9*x+y])goto end;
  }
  end:;  
  if(x==9&&y==9)return 1;
  for(n=1;n<=9;n++){
    if(check(s,x,y,n)){
      s[9*x+y]=n;
      if(solve(s))return 1;
      s[9*x+y]=0;
    }
  }
  return 0;
}

int main(int argc,char *argv[]){
  uint8_t s[81];
  uint8_t x,y;
  FILE *fp;
  fp=fopen(argv[1],"rt");
  for(x=0;x<81;x++)fscanf(fp,"%hhu",s+x);
  fclose(fp);
  for(x=0;x<9;x++){
    for(y=0;y<9;y++)printf("%d",s[9*x+y]); printf("\n");
  }
  printf("\n");
  solve(s);
  for(x=0;x<9;x++){
    for(y=0;y<9;y++)printf("%d",s[9*x+y]); printf("\n");
  }
}
