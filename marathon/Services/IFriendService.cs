
using System.Collections.Generic;
using System.Threading.Tasks;
using MarathonService.Models;

namespace MarathonService.Services {

  public interface IFriendService {
    string GetUrl();
    Task<IEnumerable<Friend>> GetFriends(long userId);
  }

}
