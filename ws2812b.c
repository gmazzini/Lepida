#include <sys/time.h>
#incluse <stdio.h>

void main(){
  struct timespec t0h,t1h,t0l,t1l;
  t0l.tv_sec=0; t0l.tv_nsec=850;
  t0h.tv_sec=0; t0h.tv_nsec=400;
  t1l.tv_sec=0; t1l.tv_nsec=450;
  t1h.tv_sec=0; t1h.tv_nsec=800;

  nanosleep(&t0h,NULL); nanosleep(&t0l,NULL);
  nanosleep(&t1h,NULL); nanosleep(&t1l,NULL);

  
}
