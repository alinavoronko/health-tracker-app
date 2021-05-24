
using System;

namespace MarathonService.Models
{
  public class Friend {
    public long UserId { get; set; }
    public long FriendId { get; set; }
    public bool IsApproved { get; set; }
    public bool IsTrainer { get; set; }
    public DateTime CreatedAt { get; set; }
    public DateTime UpdatedAt { get; set; }
  }
}
