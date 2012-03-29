## EDIT BELOW AS NEEDED ##

# Where lighttpd source tarball is extracted
LIGHTTPD_DIR = /d/src/lighttpd/1.4.x
#LIGHTTPD_DIR = /d/src/lighttpd-1.4.29
#LIGHTTPD_DIR = /d/src/lighttpd-1.4.28

######################################################################

# Although following is sufficient with recent distros, you may want
# to copy&paste same compiler flags used to build lighttpd on your system.
LIGHTTPD_DEFS = -DHAVE_CONFIG_H -DHAVE_VERSION_H \
	-DLIBRARY_DIR=\"/usr/lib/lighttpd\" \
	-DSBIN_DIR=\"/usr/sbin\" \
	-D_REENTRANT -D__EXTENSIONS__ -DPIC \
	-D_FILE_OFFSET_BITS=64 -D_LARGEFILE_SOURCE -D_LARGE_FILES

CFLAGS = $(LIGHTTPD_DEFS) $(COMPAT_DEFS) \
	-I$(LIGHTTPD_DIR) -I$(LIGHTTPD_DIR)/src \
	-g -O2 -Wall -W -Wshadow -pedantic -std=gnu99

CC = gcc
LD = gcc

SRCS = mod_auth_ticket.c base64.c
OBJS = $(SRCS:.c=.o)

.c.o:
	$(CC) $(CFLAGS) -fPIC -shared -c $<

all: mod_auth_ticket.so

mod_auth_ticket.so: $(OBJS)
	$(LD) $(LDFLAGS) -fPIC -shared -o $@ $(OBJS)

clean:
	$(RM) *.o *.so *~
