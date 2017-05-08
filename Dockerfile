FROM publysher/hugo

ENV HUGO_BASE_URL http://emoxter.com:1313
CMD hugo server -b ${HUGO_BASE_URL} --bind=0.0.0.0
