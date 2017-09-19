
 * There is no authentication in the system as of now. The service is not user facing. Since only our own clients will be using the service we can configure it to respond only to a certain set of ips. In the code as well we could setup a list of trusted ips. This is a basic setup.
 * To add further authentication we can have a HMAC setup to validate each request.
 * The current implementation for sending sms uses the Twilio. We can easily configure to use any other service. Swap out the implementation to other provider.
 * To achieve high availability we should not rely on a single provider. We could have more than one SMS provider and use both. (We could distribute load across these providers using simple round robin algo). There are other simple way to achieve the same.
 * Since we are relying on a third part service here, for high availability our system should be fault tolerance. We can get started with that from here - https://github.com/upwork/phystrix
 *  For error logging we are using Monolog. It's been configured to use Kibana and syslog for error handling. Depending on the level of error/warning the error can be logged to appropriate handler
 * The Twilio package has been setup as a helper for reuse.
 * Response Handler and Error Handler has been customized as per requirement