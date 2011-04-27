SRCS = mod_auth_ticket.c base64.c
OBJS = $(SRCS:.c=.o)

CDEFS = -DHAVE_CONFIG_H -DHAVE_VERSION_H \
	-DLIBRARY_DIR=\"/usr/lib/lighttpd\" \
	-DSBIN_DIR=\"/usr/sbin\" \
	-D_REENTRANT -D__EXTENSIONS__ -DPIC \
	-D_FILE_OFFSET_BITS=64 -D_LARGEFILE_SOURCE -D_LARGE_FILES
#CFLAGS =$(CDEFS)  -I/d/src/lighttpd/1.4.x/src
CFLAGS = $(CDEFS) -I/d/src/lighttpd-1.4.26 -I/d/src/lighttpd-1.4.26/src \
	-g -O2 -Wall -W -Wshadow -pedantic -std=gnu99

CC = gcc
LD = gcc

.c.o:
	$(CC) $(CFLAGS) -fPIC -shared -c $<

all: mod_auth_ticket.so

mod_auth_ticket.so: $(OBJS)
	$(LD) $(LDFLAGS) -fPIC -shared -o $@ $(OBJS)

clean:
	$(RM) *.o *.so *~
