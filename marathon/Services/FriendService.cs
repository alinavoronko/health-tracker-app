
using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Net.Http.Json;
using System.Text.Json;
using System.Threading.Tasks;
using MarathonService.Models;
using Microsoft.Extensions.Options;

namespace MarathonService.Services
{

  public class FriendService : IFriendService
  {
    private readonly FriendServiceOptions _options;

    public FriendService(IOptions<FriendServiceOptions> options)
    {
      _options = options.Value;
    }

    public string GetUrl()
    {
      return _options.Url;
    }

    public async Task<IEnumerable<Friend>> GetFriends(long userId)
    {
      string requestUrl = _options.Url + "user/" + userId + "/friend";

      using (var client = new HttpClient())
      {
        try
        {
          return await client.GetFromJsonAsync<IEnumerable<Friend>>(requestUrl);
        }
        catch (HttpRequestException)
        {
          Console.WriteLine("An error occured");
        }
        catch (NotSupportedException)
        {
          Console.WriteLine("The content type is not supported");
        }
        catch (JsonException)
        {
          Console.WriteLine("Invalid JSON.");
        }

        return null;
      }
    }
  }

}
