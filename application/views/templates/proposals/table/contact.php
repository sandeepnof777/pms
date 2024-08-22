
<span class="tiptip" title="<strong>Title:</strong><?php echo $proposal->clientTitle; ?><br />
    <strong>Contact:</strong><?php echo $proposal->clientFN . ' ' . $proposal->clientLN; ?><br />
    <strong>Cell:</strong><?php echo  $proposal->clientCP ?: '-'; ?><br />
    <strong>Phone:</strong><?php echo $proposal->clientBP ?: '-'; ?><br />
    <strong>Email:</strong><?php echo $proposal->clientEmail ?: '-'; ?><br />
    <p class=\'clearfix\'></p>
    <a href=" <?php echo site_url('clients/edit/' . $proposal->clientId); ?>"><?php echo $proposal->clientFN . ' ' . $proposal->clientLN ; ?></a></span>