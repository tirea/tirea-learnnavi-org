#!/bin/sh -e
#    Vrrtep CLI is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public Licence as published by
#    the Free Software Foundation, either version 3 of the Licence, or
#    (at your option) any later version.
#
#    Vrrtep CLI is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with Vrrtep CLI.  If not, see <http://www.gnu.org/licenses/>
#
#    Rewritten by Tsyalatun (c/o Twitter/facebook/learnnavi.org) to be
#    more careful with error handling.

curl_opts=
wget_opts=
quiet=
update_prog=
update_dict=y

# Parse command line options
while getopts aq OPT; do
   case ${OPT} in
   a)
	update_prog=y
	;;
   q)
	# Add a quiet mode to avoid all the noisy output from curl/wget
	curl_opts="-s -S"
	wget_opts="-q"
	quiet=y
	;;
   \?)
	echo "Unknown command line option" >&2
	exit 2
	;;
   esac
done

###curl/wget bug fix by Tsyesika###
# Checks if wget or curl is here
if [ "`which wget 2>/dev/null`" != "" ]; then
   alias prog="wget $wget_opts"
elif [ "`which curl 2>/dev/null`" != "" ]; then
   alias prog="curl $curl_opts -O"
else
   echo "Failed to update - you need curl or wget" >&2
   exit 1
fi
####################################

# Do we have zip available?
if [ "`which unzip 2>/dev/null`" != "" ]; then
   fetch_zip=yes
else
   fetch_zip=no
fi

# URLs where the program and dictionary data are stored
dicturl=http://tirea.learnnavi.org/dictionarydata/
progurl=http://tirea.learnnavi.org/source/

# List of files to download and update
dict_files="localizedWords.txt metaWords.txt naviwords.txt de.txt eng.txt est.txt hu.txt nl.txt ptbr.txt sv.txt dictversion.txt"

# Select the directory to hold the dictionary
if [ "$(id -u)" != "0" ]; then
   dir=~/.vrrtepcli
else
   # This can be simplified to...
   # dir="$(dirname "$0")"
   # cd "$dir"
   dir="$( cd "$( dirname "$0" )" && pwd )"
fi

tmpdir=$(mktemp --tmpdir -d vrrtepcli.XXXXXXXXXX)

trap 'e=$?; rm -rf $tmpdir; exit $e' EXIT

# Temporarily switch to the tmpdir for the download
pushd $tmpdir >/dev/null
files=

# Are we updating the program?
if [ -n "$update_prog" ]; then
   prog "${progurl}vrrtep-update.tar.gz"
   tar zxf vrrtep-update.tar.gz
   prog_files="$(sed 's/^[^ ]*  *//' filelist.md5)"

   files+=" $prog_files filelist.md5"
fi

# Are we updating the dictionary?
if [ -n "$update_dict" ]; then
   olddict="$(cat $dir/dictversion.txt)"
   if [ "$fetch_zip" = "yes" ]; then
      prog "${dicturl}vrrtep-dict.zip"
      unzip -q vrrtep-dict.zip
   else
      for file in $dict_files; do
         prog "${dicturl}${file}"
      done
   fi

   newdict="$(cat dictversion.txt)"

   if [ "$olddict" = "$newdict" ]; then
      echo "VrrtepCLI dictionary already up to date"
      update_dict=n
   else
      files+=" $dict_files"
   fi
fi

popd >/dev/null

# Now move the existing files out of the way
# Note, that we change the error handling trap to undo this stage now
trap 'e=$?; for f in $files; do [ -f "$dir/$f~" ] && mv -f "$dir/$f~" "$dir/$f"; done; rm -rf "$tmpdir"; exit $e' EXIT

# Move existing files out the way, and update with replacements
for file in $files; do
   mv -f "$dir/$file" "$dir/$file~"
   mv -f "$tmpdir/$file" "$dir/$file"
done

# The new dictionaries are in place, get rid of our error handling
trap 'e=$?; rm -rf $tmpdir; exit $e' EXIT

# Okay, that was all successful, remove the old files
for file in $files; do
   rm -f "$dir/$file~"
done

# Now report the new versions
if [ -z "$quiet" ]; then
   if [ "$update_prog" = "y" ]; then
      $dir/vrrtepcli.sh -v || :
   elif [ "$update_dict" = "y" ]; then
      echo "VrrtepCLI dictionary updated to $newdict."
   fi
fi
