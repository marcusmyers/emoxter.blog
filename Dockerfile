FROM publysher/hugo

ENV HUGO_BASE_URL http://emoxter.com
CMD hugo server -b ${HUGO_BASE_URL} --apendPort=false -v --bind=0.0.0.0
