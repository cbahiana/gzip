#!/bin/sh -x
# npm install -g uglify-es
# npm install -g google-closure-compiler-js
DIR=$(cd -P -- "$(dirname -- "$0")" && pwd -P)
cd $DIR
cd ./js
# client side javascript
uglifyjs --warn --comments all --beautify beautify=true,preamble='"/* do not edit this file! */"' --output ./dist/bundle.js -- ./lib/lib.js ./lib/lib.ready.js\
 ./lib/lib.utils.js ./lib/lib.event.js ./lib/lib.options.js ./lib/lib.sw.js
#./localforage-all.js
uglifyjs --compress unsafe=true,passes=3,ecma=6,toplevel=true,unsafe_comps=true,unsafe_proto=true,warnings=true --warn --mangle  -- ./dist/bundle.js > ./dist/bundle.min.js
#google-closure-compiler-js --compilationLevel=SIMPLE --languageOut=ES6 ./dist/bundle.min.js > ./dist/bundle.g.min.js
#rm ./lib-all.js
# echo "/* do not edit! */" > ./localforage-all.js
uglifyjs --warn --comments all --beautify beautify=true,preamble='"/* do not edit this file! */"' --output ./dist/localforage.js -- ./localforage/localforage.js ./localforage/localforage-getitems.js\
 ./localforage/localforage-setitems.js ./localforage/localforage-removeitems.js
uglifyjs --compress unsafe=true,passes=3,ecma=6,toplevel=true,unsafe_comps=true,unsafe_proto=true,warnings=true --warn --mangle  -- ./dist/localforage.js > ./dist/localforage.min.js
#google-closure-compiler-js --compilationLevel=SIMPLE --languageOut=ES6 ./dist/localforage.min.js > ./dist/localforage.g.min.js
#
# rm ./localforage-all.js
#
#
#
cd ../worker
#sed 's/LIB/SW/g' ../js/lib/lib.utils.js > utils/sw.utils.js
#sed 's/LIB/SW/g' ../js/lib/lib.event.js > network/sw.event.js
uglifyjs --warn --comments all --beautify beautify=true,preamble='"/* do not edit! */"' --output ./dist/browser.js -- ./browser.js
uglifyjs --compress unsafe=true,passes=3,toplevel=true,unsafe_comps=true,unsafe_proto=true,warnings=true --warn --mangle toplevel=true -- ./dist/browser.js > ./dist/browser.min.js
# google-closure-compiler-js --compilationLevel=ADVANCED --assumeFunctionWrapper=false --languageOut=ES6 ./dist/browser.js > ./dist/browser.g.min.js
#
#
#
uglifyjs --warn --comments all --beautify beautify=true,preamble='"/* do not edit! */"' --ecma=6 --output ./dist/serviceworker.js\
 -- ./serviceworker.js ./utils/sw.utils.js ./event/sw.event.promise.js\
  ./network/sw.strategies.js ./network/sw.strategies.network_first.js ./network/sw.strategies.cache_first.js ./network/sw.strategies.cache_network.js\
  ./network/sw.strategies.network_only.js ./network/sw.strategies.cache_only.js\
  ./filter/sw.filter.js\
  ./serviceworker.config.js
uglifyjs --ecma=6 --compress unsafe=true,passes=3,toplevel=true,unsafe_comps=true,unsafe_proto=true,warnings=true,drop_console=true\
  --warn --mangle toplevel=true -- ./dist/serviceworker.js > ./dist/serviceworker.min.js
#  --mangle-props
#google-closure-compiler-js --compilationLevel=ADVANCED --assumeFunctionWrapper=true --languageOut=ES6 ./dist/serviceworker.min.js > ./dist/serviceworker.g.min.js
#
cd ..
php -r 'file_put_contents("worker_version", hash_file("sha1", "worker/dist/serviceworker.min.js"));'