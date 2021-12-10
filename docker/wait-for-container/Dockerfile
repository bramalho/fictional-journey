FROM busybox

COPY ./docker/wait-for-container/entrypoint.sh /
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

CMD ["sh"]
