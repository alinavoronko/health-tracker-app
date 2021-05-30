# Start Cassandra with RAM usage @~1GB
docker run --name cassy -d -p 9042:9042 -e HEAP_NEWSIZE=1M -e MAX_HEAP_SIZE=1024M cassandra:3