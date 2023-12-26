#include <sys/time.h>
#incluse <stdio.h>

void main(){
  struct timespec t0h,t1h,t0l,t1l,trh,trl;
  int fd,len,i,j;
  unsigned long led[1000],aled;

  len=100;
  for(i=0;i<len;i++)led[i]=0;
  led[0]=(0xff)<<16 | (0x00)<<8 | 0x00;
  led[1]=(0x00)<<16 | (0xff)<<8 | 0x00;
  led[2]=(0x00)<<16 | (0x00)<<8 | 0xff;

  t0l.tv_sec=0; t0l.tv_nsec=850;
  t0h.tv_sec=0; t0h.tv_nsec=400;
  t1l.tv_sec=0; t1l.tv_nsec=450;
  t1h.tv_sec=0; t1h.tv_nsec=800;
  trl.tv_sec=0; trl.tv_nsec=55000;
  trh.tv_sec=0; trh.tv_nsec=800;

  fd=open("/sys/class/gpio/export",O_WRONLY);
  write(fd,"24",2);
  close(fd);
  fd=open("/sys/class/gpio/gpio24/direction",O_WRONLY);
  write(fd,"out",3);
  close(fd);
  
  fd=open("/sys/class/gpio/gpio24/value",O_WRONLY);

  write(fd,"1",1);
  nanosleep(&trh,NULL);
  write(fd,"0",1);
  nanosleep(&trl,NULL);
  for(i=0;i<len;i++){
    aled=led[i];
    for(j=0;j<24;j++){
      if(aled&0){
        write(fd,"1",1);
        nanosleep(&t0h,NULL);
        write(fd,"0",1);
        nanosleep(&t0l,NULL);
      }
      else {
        write(fd,"1",1);
        nanosleep(&t1h,NULL);
        write(fd,"0",1);
        nanosleep(&t1l,NULL);
      }
    }
    aled>>=1;
  }
  close(fd);

  fd=open("/sys/class/gpio/unexport",O_WRONLY);
  write(fd,"24",2);
  close(fd);

  
}
